@props([
    'danger' => null,
    'warning' => null,
    'success' => null,
    'primary' => null,
])

<span {{ $attributes->class([
    'rounded-md w-fit border px-2 py-1 text-xs font-medium text-white dark:text-white',
    'border-red-500 bg-red-500 dark:border-red-500 dark:bg-red-500' => $danger,
    'border-amber-500 bg-amber-500 dark:border-amber-500 dark:bg-amber-500' => $warning,
    'border-green-500 bg-green-500 dark:border-green-500 dark:bg-green-500' => $success,
    'border-neutral-300 bg-neutral-300 dark:border-neutral-300 dark:bg-neutral-300' => $primary,
]) }} >
    {{ $slot }}
</span>
