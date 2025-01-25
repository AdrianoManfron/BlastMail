<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            {{ __('Campaigns') }} > {{ __('Create a new campaign') }}
        </x-h2>
    </x-slot>

    <x-card>
        <x-tabs :tabs="[
            __('Setup') =>  route('campaign.create'),
            __('Email Body') =>  route('campaign.create', ['tab' => 'template']),
            __('Schedule') =>  route('campaign.create', ['tab' => 'schedule']),
        ]">
            <x-form :action="route('campaign.create', compact('tab'))" post>
                @include('campaign.create.' . $form)

                <div class="flex items-center space-x-4">
                    <x-button.link secondary :href="route('campaign.index')">
                        {{ __('Cancel') }}
                    </x-button.link>
                    <x-button type="submit">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </x-form>
        </x-tabs>
    </x-card>
</x-layouts.app>
