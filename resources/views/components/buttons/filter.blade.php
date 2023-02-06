@props(['selected' => false, 'isAscending' => true])
<button wire:loading.class='opactiy-50'
    {{ $attributes->merge(['class' =>'flex transition delay-100 items-center px-4 py-1 md:py-2 text-sm font-roboto-b text-white bg-m-blue focus:ring-m-blue focus:outline-none transition delay-100 rounded-full ' .(!$selected ? 'opacity-40' : 'border border-m-orange')]) }}>

    <div class="flex items-center gap-4">

        {{ $slot }}

        @if ($selected)
            @if ($isAscending)
                <x-icons.arrow-down />
            @else
                <x-icons.arrow-up />
            @endif
        @endif
    </div>
</button>
