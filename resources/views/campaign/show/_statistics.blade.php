<div class="space-y-4">
    <x-alert noIcon success :title="__('Sua campanha foi enviada para ' . $query['total_subscriber'] . ' assinantes da lista: ' . $campaign->emailList->title)" />

    <div class="grid grid-cols-3 gap-5">
        <x-dashboard.card :heading="$query['total_openings']" subheading="{{ __('Opens') }}" />
        <x-dashboard.card :heading="$query['unique_openings']" subheading="{{ __('Unique Opens') }}" />
        <x-dashboard.card heading="{{ $query['opening_rate'] }}%" subheading="{{ __('Open Rate') }}" />
        <x-dashboard.card :heading="$query['total_clicks']" subheading="{{ __('Clicks') }}" />
        <x-dashboard.card :heading="$query['unique_clicks']" subheading="{{ __('Unique Clicks') }}" />
        <x-dashboard.card heading="{{ $query['clicks_rate'] }}%" subheading="{{ __('Clicks Rate') }}" />
    </div>
</div>
