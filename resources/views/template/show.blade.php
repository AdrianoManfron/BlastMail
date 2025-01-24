<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            {{ __('Template') }}
        </x-h2>
    </x-slot>

    <x-card class="space-y-4">
        <div>
            <div class="flex justify-between items-center pb-6">
                <div><span class="opacity-60">{{ __('Name') }} :</span> {{ $template->name }}</div>
                <x-button.link secondary :href="route('template.index')">{{ __('Back') }}</x-button.link>
            </div>
            <div class="p-20 border-2 border-gray-400 rounded flex justify-center">{!! $template->body !!}</div>
        </div>
    </x-card>
</x-layouts.app>
