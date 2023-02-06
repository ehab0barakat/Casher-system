@props(['active'])

@php
$classes = $active ?? false ? 'block py-2 pl-3 pr-4 text-base transition bg-m-orange-l border border-white font-roboto-m focus:outline-none focus:text-white focus:bg-m-orange-l' : 'block py-2 pl-3 pr-4 text-base transition bg-white font-roboto-m focus:outline-none focus:text-white focus:bg-m-orange-l';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
