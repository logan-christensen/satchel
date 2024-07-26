<?php

namespace App\Livewire;

use App\Models\Scene;
use Livewire\Component;

class EditScene extends Component
{
    public Scene $scene;

    public ?string $sceneContent = "";
    public ?string $sceneName = "";
    public ?string $sceneSummary = "";
    public string $selectedTab = "draft";

    public $queryString = ['selectedTab'];

    public function render()
    {
        return view('livewire.edit-scene');
    }

    public function mount()
    {
        $this->sceneContent = $this->scene->content;
        $this->sceneName = $this->scene->name;
        $this->sceneSummary = $this->scene->summary;
    }

    public function updated()
    {

        $this->validate([
            'sceneName' => 'required|min:3',
            'sceneSummary' => 'nullable|string',
            'sceneContent' => 'required|string',
        ]);

        $this->scene->update([
            'name' => $this->sceneName,
            'summary' => $this->sceneSummary,
            'content' => $this->sceneContent,
        ]);

        $this->dispatch('sceneUpdated', $this->scene->id);
    }
}
