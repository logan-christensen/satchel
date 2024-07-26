<div>
    <x-mary-tabs wire:model="selectedTab">
        <x-mary-tab name="draft"
                    label="Draft"
                    icon="o-document">
            <x-mary-editor wire:model.live="sceneContent"
                           folder="projects/{{ $scene->project->id }}/scenes/{{ $scene->id }}/draft"
                           :config="[
                               'plugins' => 'autoresize',
                               'max_height' => 700,
                               'min_height' => 400,
                           ]"
                           wire:key="editor-scene-{{ $scene->id }}" />
        </x-mary-tab>
        <x-mary-tab name="outline"
                    label="Outline"
                    icon="o-adjustments-horizontal">
            <x-mary-input wire:model.live="sceneName"
                          label="Scene Name"
                          inline />
            <x-mary-textarea wire:model.live="sceneSummary"
                             label="Scene Summary"
                             placeholder="Optional Summary"
                             style="min-height: 60vh;" />
        </x-mary-tab>

    </x-mary-tabs>
</div>
