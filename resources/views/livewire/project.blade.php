<x-slot:title>{{ $project->name }}</x-slot:title>




<div x-data="{
    collapsed: false
}">
    <div class="flex flex-col h-full"
         :class="{
             'w-9/12': !collapsed,
             'w-11/12': collapsed
         }">
        <h1><a href="#"
               wire:click="$set('showEditName', true)">{{ $project->name }} <x-mary-icon
                             name="s-pencil"></x-mary-icon></a>
        </h1>


        <x-mary-modal class="backdrop-blur"
                      wire:model="showEditName">
            <x-mary-form wire:submit="updateProjectDetails">
                <x-mary-input label="Project Name"
                              wire:model="projectName"
                              inline />
                <x-mary-textarea label="Description"
                                 wire:model="projectDescription"
                                 placeholder="Optional Description" />
                <x-slot:actions>
                    <x-mary-button class="btn-primary"
                                   type="submit"
                                   spinner="save">Save</x-mary-button>
                </x-slot:actions>
            </x-mary-form>
        </x-mary-modal>


        <div>
            @if ($scene)
                <livewire:edit-scene :scene="$scene"
                                     wire:key="scene-{{ $scene->id }}" />
            @endif

        </div>
    </div>
    <!-- Outline Sidebar -->
    <div class="fixed right-0 w-2/12  h-full top-0 p-2"
         :class="{
             'w-3/12 bg-white': !collapsed,
             'w-1/12': collapsed
         }">
        <div class="flex flex-col h-full">
            <div class="flex-grow mb-6"
                 x-show="!collapsed">

                <h2 x-show="!collapsed">Scenes</h2>
                <livewire:scene-list :project="$project" />
            </div>
            <x-mary-menu x-show="!collapsed">
                <x-mary-menu-item @click="collapsed = !collapsed"
                                  icon="o-chevron-right"
                                  title="Hide Outline" />
            </x-mary-menu>
            <x-mary-menu x-show="collapsed">
                <x-mary-menu-item @click="collapsed = !collapsed"
                                  icon="o-chevron-left"
                                  title="Outline" />
            </x-mary-menu>
        </div>
    </div>

</div>
