@props([
    'post' => null,
    'delete' => null,
    'flat' => false
])

@php
    $method = ($post or $delete) ? 'POST' : 'GET';
@endphp

<form {{ $attributes->class(['flex flex-col gap-4' => ! $flat]) }} method="{{ $method }}">
    @if ($method != 'GET')
        @csrf
    @endif

    @if ($delete)
        @method('DELETE')
    @endif

    {{ $slot }}
</form>
