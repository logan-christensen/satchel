<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect"
          href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
          rel="stylesheet" />
    @livewireStyles

    <!-- Scripts -->
    <script src="https://cdn.tiny.cloud/1/rk3g4f6v419y35gvl58d0me0eowy4di6hke00ot7chuhbqum/tinymce/7/tinymce.min.js"
            referrerpolicy="origin"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-mary-nav class="lg:hidden"
                sticky>
        <x-slot:brand>
            <div class="ml-5 pt-5">App</div>
        </x-slot:brand>
        <x-slot:actions>
            <label class="lg:hidden mr-3"
                   for="main-drawer">
            </label>
        </x-slot:actions>
    </x-mary-nav>

    {{-- MAIN --}}
    <x-mary-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar
                class="bg-base-100 lg:bg-inherit"
                drawer="main-drawer"
                collapsible>

            {{-- BRAND --}}
            <div class="ml-5 pt-5">{{ config('app.name') }}</div>

            {{-- MENU --}}
            <x-mary-menu activate-by-route>

                {{-- User --}}
                @if ($user = auth()->user())
                    <x-mary-menu-separator />

                    <x-mary-list-item class="-mx-2 !-my-2 rounded"
                                      :item="$user"
                                      value="name"
                                      sub-value="email"
                                      no-separator
                                      no-hover>
                        <x-slot:actions>
                            <x-mary-button class="btn-circle btn-ghost btn-xs"
                                           icon="o-power"
                                           tooltip-left="logoff"
                                           no-wire-navigate
                                           link="/logout" />
                        </x-slot:actions>
                    </x-mary-list-item>

                    <x-mary-menu-separator />
                @endif

                <x-mary-menu-item title="Hello"
                                  icon="o-sparkles"
                                  link="/" />

                <x-mary-menu-sub title="Projects"
                                 icon="o-cog-6-tooth">
                    @foreach (auth()->user()->projects as $project)
                        <x-mary-menu-item title="{{ $project->name }}"
                                          icon="o-folder"
                                          link="{{ route('projects.show', $project) }}" />
                    @endforeach
                    <x-mary-menu-item title="Manage Projects"
                                      icon="o-sparkles"
                                      link="/projects" />
                </x-mary-menu-sub>

            </x-mary-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-mary-main>

    {{-- Toast --}}
    <x-mary-toast />

    @livewireScriptConfig
</body>

</html>
