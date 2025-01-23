<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            {{ __('Template') }}
        </x-h2>
    </x-slot>

    <x-card class="space-y-4">
        <div>
            <div>{{ $template->name }}</div>
            <div class="p-20 border-2 border-gray-400 rounded flex justify-center">{!! $template->body !!}</div>
        </div>
    </x-card>
</x-layouts.app>
