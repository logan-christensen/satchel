<?php

namespace App\Livewire;

use App\Models\Project;
use App\Services\AiService;
use Livewire\Component;

class SceneList extends Component
{
    public Project $project;
    public bool $showAddScene = false;
    public string $sceneName = "";
    public string $sceneSummary = "";
    public int $sceneOrder = 0;
    public int $sceneId;
    protected $queryString = ['sceneId'];

    public function render()
    {
        return view('livewire.scene-list');
    }

    public function saveScene()
    {
        $this->validate([
            'sceneName' => 'required|min:3',
            'sceneSummary' => 'nullable|string',
            'sceneOrder' => 'required|integer|min:0',
        ]);

        $this->project->scenes()->where('order', '>=', $this->sceneOrder)->increment('order');
        $this->project->scenes()->create([
            'name' => $this->sceneName,
            'summary' => $this->sceneSummary,
            'order' => $this->sceneOrder,
        ]);

        $this->showAddScene = false;
        $this->resetExcept(['project']);
    }

    public function reorderScenes($sceneId, $position)
    {
        $scene = $this->project->scenes()->find($sceneId);
        $oldIndex = $scene->order;
        $this->normalizeSortOrder();
        $scene->update(['order' => $position]);
        $newIndex = $position;

        if ($scene->wasChanged('order')) {
            if ($oldIndex < $newIndex) {
                $this->project->scenes()
                    ->where('id', '!=', $sceneId)
                    ->whereBetween('order', [$oldIndex, $newIndex])
                    ->where('order', '!=', $oldIndex)
                    ->decrement('order');
            } else {
                $this->project->scenes()
                    ->where('id', '!=', $sceneId)
                    ->whereBetween('order', [$newIndex, $oldIndex])
                    ->where('order', '!=', $oldIndex)
                    ->increment('order');
            }
        }
    }

    private function normalizeSortOrder()
    {
        $this->project->scenes()->orderBy('order')->get()->each(function ($scene, $index) {
            $scene->update(['order' => $index]);
        });
    }

    public function updatedSceneId(int $sceneId)
    {
        $this->dispatch('sceneSelected', $this->sceneId);
    }

    public function deleteScene($sceneId)
    {
        $scene = $this->project->scenes()->find($sceneId);
        $scene->delete();
        $sceneOrder = $scene->order;
        $this->normalizeSortOrder();
        $this->updatedSceneId($sceneOrder);
    }

    public function insertSceneAtIndex($index)
    {
        $this->sceneOrder = $index;
        $this->showAddScene = true;
    }

    public function generateSummary(int $sceneId)
    {
        $scene = $this->project->scenes()->find($sceneId);

        $aiService = new AiService();
        $aiService->addMessage(get_prompt('generate-scene-summary', [
            'scene_title' => $scene->name,
            'scene' => $scene->getTextContent()
        ]));
        $aiService->getResponse();
        $scene->summary = $aiService->getLastMessage();
        $scene->save();
        $this->dispatch('sceneSelected', $sceneId);
    }
}
