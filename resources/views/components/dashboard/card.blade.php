@props([
    'heading',
    'subheading',
])

<div class="border-2 border-slate-700 p-8 bg-slate-900 text-center rounded-2xl">
    <div class="font-semibold text-5xl font-mono">{{ $heading }}</div>
    <div class="text-xl mt-1 opacity-70">{{ $subheading }}</div>
</div>
