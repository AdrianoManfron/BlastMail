@props([
    'headers',
    'body'
])

<div class="overflow-hidden w-full overflow-x-auto rounded-md border border-neutral-300 dark:border-neutral-700">
    <table class="w-full text-left text-sm text-neutral-600 dark:text-neutral-300">
        <thead class="border-b border-neutral-300 bg-neutral-50 text-sm text-neutral-900 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
            <tr>
                @foreach ($headers as $header)
                    <th scope="col" class="p-4">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-300 dark:divide-neutral-700">
            {{ $body }}
        </tbody>
    </table>
</div>
