<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class Projects extends Component
{
    public bool $showAddProjectForm = false;

    public string $name = '';
    public string $description = "";

    public $rules = [
        'name' => 'required|string|min:3',
        'description' => 'nullable|string',
    ];

    public function render()
    {
        return view('livewire.projects', [
            'projects' => auth()->user()->projects()->paginate(),
        ]);
    }

    public function saveProject()
    {
        $this->validate();
        auth()->user()->projects()->create([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        $this->reset(['name', 'description']);
        $this->showAddProjectForm = false;
    }
}
