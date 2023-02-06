@props(['id', 'name', 'phone', 'editAction', 'deleteAction'])
<div
    class="rounded-lg shadow-lg p-4 lg:p-2 2xl:p-4 bg-[#6E7180] bg-opacity-20 gap-4 lg:gap-2 2xl:gap-4 items-center flex justify-between border border-m-orange/20">

    <div class="flex items-center gap-4">

        <!-- Avatar -->
        <img class="h-16 border rounded-full border-m-blue/30 md:h-24 lg:h-20 2xl:h-24 lg:w-20 2xl:w-24"
            src="{{ asset('img/avatars/person.png') }}" alt="avatar-man">

        <!-- Title / Subtitle / Sub-subtitle-->
        <div class="flex flex-col items-start justify-center gap-2">

            <span class="2xl:text-xl font-roboto-m">{{ $name }}</span>

            <span class="text-sm lg:text-base 2xl:text-lg font-roboto">{{ $phone }}</span>

        </div>

    </div>

    <div class="flex flex-col items-center justify-center gap-1 md:flex-row">

        <span wire:click="{{ $editAction }}({{ $id }})"
            class="hidden p-2 text-white transition delay-100 border rounded-full shadow-2xl cursor-pointer lg:block hover:border-white border-m-orange hover:shadow-m-orange-d bg-m-blue hover:text-m-orange-l"
            title="{{ __('fields.edit') }}">
            <x-icons.edit />
        </span>

        <span wire:click="{{ $editAction }}Modal({{ $id }})"
            class="block p-2 text-white transition delay-100 border rounded-full shadow-2xl cursor-pointer lg:hidden hover:border-white border-m-orange hover:shadow-m-orange-d bg-m-blue hover:text-m-orange-l"
            title="{{ __('fields.edit') }}">
            <x-icons.edit />
        </span>

        <span wire:click="{{ $deleteAction }}({{ $id }})"
            class="p-2 text-white transition delay-100 border rounded-full shadow-2xl cursor-pointer hover:border-white border-m-orange hover:shadow-m-orange-d bg-m-blue hover:text-m-orange-l"
            title="{{ __('fields.delete') }}">
            <x-icons.delete />
        </span>

    </div>

</div>