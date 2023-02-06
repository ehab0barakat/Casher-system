@props(['disabled' => false])

<input autocomplete="off" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-gray-300 focus:border-m-orange bg-opacity-90 text-white focus:ring bg-m-blue placeholder-white focus:ring-m-orange focus:ring-opacity-50 delay-100 transition rounded-md shadow-sm',
]) !!}>
