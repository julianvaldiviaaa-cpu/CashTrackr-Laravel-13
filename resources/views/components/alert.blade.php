@props(['type' => 'succes', 'message' => ''])

@php
    $colors = [
        'succes' => 'text-green-700 border border-green-500 bg-green-100',
        'error' => 'text-red-700 border border-red-500 bg-red-100',
    ];

    $class = $colors[$type] ?? $colors['succes'];
@endphp

@if ($message)
    <p class="my-10 text-center text-sm  py-3 px-2 font-bold border-2 {{ $class }}">
        {{ $message }}
    </p>
@endif
