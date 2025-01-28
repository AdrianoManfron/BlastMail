<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            <a href="{{ route('campaign.index') }}">{{ __('Campaigns') }}</a> > {{ $campaign->name }} > {{ __(str($what)->title()->toString()) }}
        </x-h2>
    </x-slot>

    <x-card>
        <x-tabs :tabs="[
            __('Statistics') =>  route('campaign.show', ['campaign' => $campaign->id, 'what' => 'statistics']),
            __('Open') =>  route('campaign.show', ['campaign' => $campaign->id, 'what' => 'open']),
            __('Clicked') =>  route('campaign.show', ['campaign' => $campaign->id, 'what' => 'clicked']),
        ]">
            @include('campaign.show._' . $what)
        </x-tabs>
    </x-card>
</x-layouts.app>
