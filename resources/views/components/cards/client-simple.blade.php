@props(['id', 'name', 'phone', 'selected' => 'false'])
<div
    class="rounded-lg shadow-lg p-4 2xl:p-4 lg:p-2 bg-[#6E7180] bg-opacity-20 gap-4 2xl:gap-4 lg:gap-2 items-center flex justify-between border border-m-orange/20">

    <div class="flex items-center gap-4 2xl:gap-4 lg:gap-2">

        <!-- Dot -->
        <span class="hidden border rounded-full bg-m-orange border-m-blue/30 2xl:block 2xl:h-4 2xl:w-4"></span>

        <!-- Title / Subtitle / Sub-subtitle-->
        <div class="flex flex-col items-start justify-center gap-1">

            <span class="font-roboto-m">{{ $name }}</span>

            <span class="text-sm 2xl:text-sm lg:text-xs font-roboto">{{ $phone }}</span>

        </div>

    </div>

    <div class="flex flex-col items-center justify-center gap-1 md:flex-row">

        <span wire:click='selectClient({{ $id }})' @class([
            'text-m-orange-l' => $selected,
            'text-white' => !$selected,
            'p-2 transition delay-100 border rounded-full shadow-2xl cursor-pointer lg:block hover:border-white border-m-orange hover:shadow-m-orange-d bg-m-blue hover:text-m-orange-l' => true,
        ])
            title="{{ __('fields.edit') }}">
            <x-icons.check />
        </span>

    </div>

</div>
