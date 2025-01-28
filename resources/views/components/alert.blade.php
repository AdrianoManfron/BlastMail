@props([
    'title',
    'success' => null,
    'info' => null,
    'warning' => null,
    'danger' => null,
    'noIcon' => null,
])

<div @class([
    'relative w-full overflow-hidden rounded-md border bg-white text-neutral-600 dark:bg-neutral-950 dark:text-neutral-300',
    'border-green-500' => $success,
    'border-sky-500' => $info,
    'border-amber-500' => $warning,
    'border-red-500' => $danger,
]) role="alert">
    <div @class([
        'flex w-full items-center gap-2 p-4',
        'bg-green-500/10' => $success,
        'bg-sky-500/10' => $info,
        'bg-amber-500/10' => $warning,
        'bg-red-500/10' => $danger,
    ])>
        <div @class([
            'rounded-full p-1',
            'bg-green-500/15 text-green-500' => $success,
            'bg-sky-500/15 text-sky-500' => $info,
            'bg-amber-500/15 text-amber-500' => $warning,
            'bg-red-500/15 text-red-500' => $danger,
        ]) aria-hidden="true">
            @unless ($noIcon)
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                </svg>
            @endunless
        </div>
        <div class="ml-2">
            <h3 @class([
                'text-sm font-semibold',
                'text-green-500' => $success,
                'text-sky-500' => $info,
                'text-amber-500' => $warning,
                'text-red-500' => $danger,
            ])>{{ $title }}</h3>
            @if ($slot)
                <p class="text-xs font-medium sm:text-sm">{{ $slot }}</p>
            @endif
        </div>
    </div>
</div>
