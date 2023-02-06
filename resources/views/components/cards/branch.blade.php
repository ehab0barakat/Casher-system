@props(['id', 'name', 'editAction', 'deleteAction'])
<div
    class="rounded-lg shadow-lg p-4 lg:p-2 2xl:p-4 bg-[#6E7180] bg-opacity-20 gap-4 lg:gap-2 2xl:gap-4 items-center flex justify-between border border-m-orange/20">

    <div class="flex items-center gap-4">

        <!-- Avatar -->
        <img class="w-24 h-24 border rounded-full border-m-blue/30 lg:h-20 2xl:h-24 lg:w-20 2xl:w-24"
            src="{{ asset('img/avatars/branch.png') }}"
            alt="{{ \Illuminate\Support\Str::kebab($name) . '-photo' }}">

        <!-- Title / Subtitle / Sub-subtitle-->
        <div class="flex flex-col items-start justify-center">

            <span class="lg:text-lg 2xl:text-xl font-roboto-m">{{ $name }}</span>

        </div>

    </div>

    {{-- NOT MAIN BRANCH --}}
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

        @if ($id != 1)
            <span wire:click="{{ $deleteAction }}({{ $id }})"
                class="p-2 text-white transition delay-100 border rounded-full shadow-2xl cursor-pointer hover:border-white border-m-orange hover:shadow-m-orange-d bg-m-blue hover:text-m-orange-l"
                title="{{ __('fields.delete') }}">
                <x-icons.delete />
            </span>
        @endif

    </div>

</div>
