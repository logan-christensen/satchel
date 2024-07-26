import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import { sort } from '@alpinejs/sort';
// Register any Alpine directives, components, or plugins here...
Alpine.plugin(sort);
Livewire.start();