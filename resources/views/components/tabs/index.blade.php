@props(['tabs' => []])

<div class="w-full">
    <div class="flex gap-2 overflow-x-auto border-b border-neutral-300 dark:border-neutral-700">
        @foreach ($tabs as $title => $route)
            @php
                $selected = request()->getUri() == $route;
            @endphp

            <a @class([
                'h-min px-4 py-2 text-sm',
                'font-bold text-black border-b-2 border-black dark:border-white dark:text-white' => $selected,
                'text-neutral-600 font-medium dark:text-neutral-300 dark:hover:border-b-neutral-300 dark:hover:text-white hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900' => !$selected,
            ]) href="{{ $route }}">{{ $title }}</a>
        @endforeach
    </div>
    <div class="px-2 py-4 text-neutral-600 dark:text-neutral-300">
        {{ $slot }}
    </div>
</div>
