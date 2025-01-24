@props([
    'post' => null,
    'put' => null,
    'patch' => null,
    'delete' => null,
    'flat' => false
])

@php
    $method = ($post or $put or $patch or $delete) ? 'POST' : 'GET';
@endphp

<form {{ $attributes->class(['flex flex-col gap-4' => ! $flat]) }} method="{{ $method }}">
    @if ($method != 'GET')
        @csrf
    @endif

    @if ($put)
        @method('PUT')
    @endif

    @if ($patch)
        @method('PATCH')
    @endif

    @if ($delete)
        @method('DELETE')
    @endif

    {{ $slot }}
</form>
