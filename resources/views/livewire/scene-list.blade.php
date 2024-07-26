<div class="h-full flex-col flex"
     x-data="{
         sceneId: @entangle('sceneId').live,
         handleSort: (sceneId, position) => {
             console.log(sceneId, position);
             $wire.call('reorderScenes', sceneId, position);
         }
     }">
    <ul class="menu flex-grow flex-nowrap"
        style="max-height: 80vh; overflow: auto scroll"
        x-sort="handleSort">
        @foreach ($project->scenes as $scene)
            <li x-sort:item="{{ $scene->id }}">
                <ul class="p-0 m-0">
                    <x-mary-list-item class="rounded bg-white"
                                      :item="$scene"
                                      value="name"
                                      sub-value="summary"
                                      @class([
                                          'mary-active-menu bg-base-300' => $sceneId == $scene->id,
                                      ])
                                      avatar="image"
                                      wire:click="$set('sceneId', {{ $scene->id }})">
                                      
                        <x-slot:actions>
                            <x-mary-dropdown class="btn-outline"
                                             icon="o-ellipsis-vertical">
                                {{-- By default any click closes dropdown --}}
                                <x-mary-menu-item title="Delete Scene" wire:click="deleteScene({{ $scene->id}})" />

                                <x-mary-menu-item title="Insert Scene Before" wire:click="insertSceneAtIndex({{ $scene->order }})" />
                                <x-mary-menu-item title="Insert Scene After" wire:click="insertSceneAtIndex({{ $scene->order + 1 }})" />
                            </x-mary-dropdown>

                        </x-slot:actions>
                    </x-mary-list-item>
                </ul>
            </li>
        @endforeach
    </ul>

    <x-mary-button class="btn-primary"
                   label="New Scene"
                   icon="o-plus"
                   wire:click="$set('showAddScene', true)" />
    <x-mary-modal class="backdrop-blur"
                  wire:model="showAddScene">
        <x-mary-form wire:submit="saveScene">
            <x-mary-input label="Scene Name"
                          wire:model="sceneName"
                          inline />
            <x-mary-textarea label="Summary"
                             wire:model="sceneSummary"
                             placeholder="Optional Summary" />
            <x-slot:actions>
                <x-mary-button class="btn-primary"
                               type="submitNewScene"
                               spinner="save">Save</x-mary-button>
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>
