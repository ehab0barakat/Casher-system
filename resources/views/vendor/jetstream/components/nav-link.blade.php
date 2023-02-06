@props(['active', 'src', 'alt', 'text'])

@php
$classes = $active ?? false ?
'flex flex-col w-24 lg:w-20 2xl:w-24 items-center gap-2 px-6 lg:px-1 2xl:px-6 py-2 transition duration-200 delay-100 border border-white shadow-lg hover:bg-m-orange bg-m-orange-l rounded-2xl focus:outline-none hover:scale-105 hover:-translate-y-1' :
'flex flex-col w-24 lg:w-20 2xl:w-24 items-center  gap-2 px-6 lg:px-1 2xl:px-6 py-2 bg-white transition duration-100 delay-200 border border-white shadow-lg hover:bg-m-orange rounded-2xl focus:outline-none hover:scale-105 hover:-translate-y-1';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <div class="flex flex-col gap-2">
        <span><img class="h-8 mx-auto" src="{{ $src }}" alt='{{ $alt }}'></span>
        <span class="text-sm text-black 2xl:text-base font-roboto-l">{{ $text }}</span>
    </div>
</a>
