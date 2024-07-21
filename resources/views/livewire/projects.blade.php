<x-slot:title>Projects</x-slot:title>

<div>


    <h1>Projects</h1>

    @foreach($projects as $project)
    <x-mary-list-item :item="$project" value="name" sub-value="description" class="rounded bg-white" :link="route('projects.show', $project)">
        <x-slot:actions>
            <x-mary-button icon="o-trash" class="btn-circle btn-ghost btn-xs" tooltip-left="delete" wire:click="deleteProject({{ $project->id }})" />
        </x-slot:actions>
    </x-mary-list-item>
    @endforeach

    <x-mary-drawer wire:model="showAddProjectForm" class="w-11/12 lg:w-1/2" right title="Add Project" separator with-close-button close-on-escape>
        <div>
            <x-mary-form wire:submit="saveProject">
                <x-mary-input label="Project Name" wire:model="name" />
                <x-mary-input label="Description (Optional)" wire:model="description" placeholder="Optional Description" />
                <x-slot:actions>
                    <x-mary-button type="submit" class="btn-primary" spinner="save">Save</x-mary-button>
                </x-slot:actions>
            </x-mary-form>

        </div>
    </x-mary-drawer>

    <x-mary-menu-separator />

    <x-mary-button label="New Project" wire:click="$toggle('showAddProjectForm')" class="btn-success" icon="o-plus" />
</div>