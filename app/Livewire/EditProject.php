<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Scene;

class EditProject extends Component
{

    public Project $project;
    public string $projectName = "";
    public string $projectDescription = "";

    public bool $showEditName = false;
    public bool $showAddScene = false;
    public bool $expandOutline = true;

    public int $sceneId;

    public ?Scene $scene = null;

    public ?string $sceneContent = "";

    protected $queryString = ['sceneId'];

    public $listeners = ['sceneSelected' => 'updatedSceneId'];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->projectName = $project->name;
    }

    public function render()
    {
        return view('livewire.project');
    }

    public function updateProjectDetails()
    {
        $this->validate([
            'projectName' => 'required|min:3',
            'projectDescription' => 'nullable|string',
        ]);
        $this->project->update([
            'name' => $this->projectName,
            'description' => $this->projectDescription,
        ]);
        $this->showEditName = false;
    }

    public function updatedSceneId(int $sceneId)
    {
        $this->scene = $this->project->scenes()->find($sceneId);
        $this->sceneContent = $this->scene->content;
    }

    public function updatedSceneContent()
    {
        $this->scene->update(['content' => $this->sceneContent]);
    }
}
