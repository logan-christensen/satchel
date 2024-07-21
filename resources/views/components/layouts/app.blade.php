<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title ?? 'Page Title' }}
        </h2>
    </x-slot>

    <div class="">

        {{ $slot }}

    </div>
</x-app-layout>