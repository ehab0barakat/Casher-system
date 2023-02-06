@props([
    'placeholder' => null,
    'trailingAddOn' => null,
])

<div class="flex text-white">
    <select
        {{ $attributes->merge(['class' =>'form-select block w-full font-roboto-m pl-3 pr-10 py-2 text-base bg-m-blue leading-6 border-m-orange-300 focus:outline-none focus:shadow-outline-blue focus:border-m-orange-300 sm:text-sm sm:leading-5' .($trailingAddOn ? ' rounded-r-none' : '')]) }}>
        @if ($placeholder)
            <option class="bg-white font-roboto-b" disabled value="">{{ $placeholder }}</option>
        @endif

        {{ $slot }}
    </select>

    @if ($trailingAddOn)
        {{ $trailingAddOn }}
    @endif
</div>
