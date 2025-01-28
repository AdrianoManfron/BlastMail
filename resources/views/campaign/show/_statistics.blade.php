<div class="space-y-4">
    <x-alert noIcon success :title="__('Sua campanha foi enviada para 10 assinantes da primeira lista.')" />

    <div class="grid grid-cols-3 gap-5">
        <x-dashboard.card heading="01" subheading="{{ __('Opens') }}" />
        <x-dashboard.card heading="02" subheading="{{ __('Unique Opens') }}" />
        <x-dashboard.card heading="20%" subheading="{{ __('Open Rate') }}" />
        <x-dashboard.card heading="0" subheading="{{ __('Clicks') }}" />
        <x-dashboard.card heading="0" subheading="{{ __('Unique Clicks') }}" />
        <x-dashboard.card heading="20%" subheading="{{ __('Clicks Rate') }}" />
    </div>
</div>
