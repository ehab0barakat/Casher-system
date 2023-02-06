@props(['id', 'name', 'quantity', 'retailPrice', 'costPrice', 'url', "category_name" , 'barcodeUrl', 'supplierNameAndCompany', 'editAction', 'deleteAction'])
<div
    class="rounded-lg shadow-lg p-4 lg:p-2 2xl:p-4 bg-[#6E7180] bg-opacity-20 gap-4 lg:gap-2 2xl:gap-4 items-center flex justify-between border border-m-orange/20">

    <div class="flex items-center gap-4">

        <!-- Avatar -->
        <img class="w-20 h-20 border rounded-full border-m-blue/30 lg:h-20 2xl:h-24 lg:w-20 2xl:w-24"
            src="{{ $url }}" alt="{{ \Illuminate\Support\Str::kebab($name) . '-photo' }}">

        <!-- Title / Subtitle / Sub-subtitle-->
        <div class="flex flex-col items-start justify-center gap-2 lg:gap-1 2xl:gap-2">

            <span class="text-base lg:texl-lg 2xl:text-xl font-roboto-m">{{ $name }}</span>

            <span class="text-sm lg:text-base 2xl:text-lg font-roboto">
                <span class="font-roboto-b">{{ __('fields.quantity-label') }}</span>
                {{ $quantity }}
            </span>

            <span class="hidden text-sm 2xl:text-lg 2xl:block font-roboto">
                <span class="font-roboto-b">{{ __('fields.cost-label') }}</span>
                {{ $costPrice }} -
                <span class="font-roboto-b">{{ __('fields.retail-label') }}</span>
                {{ $retailPrice }}
            </span>

            <span class="block text-sm lg:text-base 2xl:hidden font-roboto">
                <span class="font-roboto-b">{{ __('fields.cost-label') }}</span><span> {{ $costPrice }}</span><br>
                <span class="font-roboto-b">{{ __('fields.retail-label') }}</span>
                <span>{{ $retailPrice }}</span>
            </span>

            <span class="text-sm 2xl:text-base font-roboto-l">
                <span class="font-roboto-b">{{ __('fields.supplier-label') }}</span>
                {{ $supplierNameAndCompany }} -
            </span>

            <span class="text-sm 2xl:text-base font-roboto-l">
                <span class="font-roboto-b">{{ __('fields.category-label') }}</span>
                {{-- {{ $category_name }} - --}}
            </span>

        </div>

    </div>

    <div class="flex flex-col items-center justify-center gap-1 md:flex-row">

        <a href="{{ route('admin.barcode', ['productId' => $id]) }}" target="_blank" rel="noopener noreferrer">
            <span
                class="hidden p-2 text-white transition delay-100 border rounded-full shadow-2xl cursor-pointer lg:block hover:border-white border-m-orange hover:shadow-m-orange-d bg-m-blue hover:text-m-orange-l"
                title="{{ __('fields.barcode') }}">
                <x-icons.barcode />
            </span>
        </a>

        <a href="{{ route('admin.barcode', ['productId' => $id]) }}" target="_blank" rel="noopener noreferrer">
            <span
                class="block p-2 text-white transition delay-100 border rounded-full shadow-2xl cursor-pointer lg:hidden hover:border-white border-m-orange hover:shadow-m-orange-d bg-m-blue hover:text-m-orange-l"
                title="{{ __('fields.barcode') }}">
                <x-icons.barcode />
            </span>
        </a>

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
