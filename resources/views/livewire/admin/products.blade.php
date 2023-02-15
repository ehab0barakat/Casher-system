<div>

    <!-- Header -->
    <x-page.header>

        <x-slot name='header'>
            {{ __('fields.products') }}
        </x-slot>

        <x-slot name='actions'>

            <x-buttons.rounded wire:click='showAddModal'>
                <span>
                    <x-icons.plus />
                </span>
            </x-buttons.rounded>

            <x-buttons.rounded wire:click='showRestockModal'>
                <span>
                    <x-icons.restock color='white' />
                </span>
            </x-buttons.rounded>

            <x-buttons.rounded wire:click="$toggle('showSearch')">

                @if ($showSearch)
                    <span>
                        <x-icons.close />
                    </span>
                @else
                    <span>
                        <x-icons.search-round />
                    </span>
                @endif

            </x-buttons.rounded>

        </x-slot>

        <x-slot name='secondaryActions'>

            @if ($showSearch)
                <span class="w-full">
                    <x-jet-input id="searchQuery" wire:model.lazy='searchQuery' class="block w-full h-11" type="text"
                        name="searchQuery" placeholder="{{ __('placeholders.search-by-name') }}" :value="old('searchQuery')" />
                </span>
            @else
                <div class="flex flex-col items-center justify-between gap-4">

                    <div class="flex items-center justify-center gap-4">
                        <x-buttons.filter wire:click="sortBy('created_at')" :selected="$field == 'created_at'" :isAscending="$direction == 'asc'">
                            {{ __('fields.created-at') }}
                        </x-buttons.filter>

                        <x-buttons.filter wire:click="sortBy('name')" :selected="$field == 'name'" :isAscending="$direction == 'asc'">
                            {{ __('fields.name') }}
                        </x-buttons.filter>
                    </div>

                    <div class="flex items-center justify-center gap-4">
                        <x-buttons.filter wire:click="sortBy('costPrice')" :selected="$field == 'costPrice'" :isAscending="$direction == 'asc'">
                            {{ __('fields.cost-price') }}
                        </x-buttons.filter>

                        <x-buttons.filter wire:click="sortBy('retailPrice')" :selected="$field == 'retailPrice'" :isAscending="$direction == 'asc'">
                            {{ __('fields.retail-price') }}
                        </x-buttons.filter>

                        <x-buttons.filter wire:click="sortBy('supplier_id')" :selected="$field == 'supplier_id'" :isAscending="$direction == 'asc'">
                            {{ __('fields.supplier') }}
                        </x-buttons.filter>
                    </div>

                </div>
            @endif

        </x-slot>

    </x-page.header>

    <!-- Body -->
    <div class="py-2 lg:py-4 2xl:py-4">

        <div class="flex gap-4 px-4 mx-auto md:px-10 max-h-[71vh] md:max-h-[81vh] min-h-[71vh] md:min-h-[81vh]">

            <!-- Products List -->
            <div wire:loading.class='opacity-50' @class([
                'opacity-50' => $showEdit,
                'flex flex-col w-full gap-4 p-0 lg:p-4 overflow-y-auto transition delay-100 bg-transparent lg:bg-white lg:border lg:shadow-md lg:shadow-m-orange-l/50 lg:border-m-orange-l/20 rounded-xl lg:w-1/2' => true,
            ])>
                @forelse ($products as $key => $product)
                    <div wire:key='wkw-{{ $key }}'>
                        <x-cards.product id="{{ $product->id }}" name="{{ $product->name }}"
                            url="{{ $product->photoOrDefaultUrl }}" barcodeUrl="{{ $product->barcodeUrl }}"
                            costPrice="{{ $product->costPriceInCurrency }}"
                            retailPrice="{{ $product->retailPriceInCurrency }}"
                            supplierNameAndCompany="{{ $product->supplierNameAndCompany }}"
                            categoryName="{{ $product->category->name }}" editAction='showEdit'
                            quantity="{{ $product->quantityInThreeDigits }}" deleteAction='showDelete' />
                    </div>
                @empty
                    <div class="flex items-center justify-center flex-grow">

                        <span class="text-m-blue">
                            <x-icons.info size="24" />
                        </span>

                    </div>
                @endforelse

            </div>

            <!-- Oparation Boxes -->
            <div class="flex-col items-center flex-grow hidden w-1/2 gap-4 overflow-hidden lg:flex">

                <!-- Search & Sorting -->
                <div @class([
                    'opacity-50' => $showEdit,
                    'w-full px-8 py-10 lg:px-4 lg:py-5 2xl:px-8 2xl:py-10 transition delay-100 my-auto bg-white border shadow-mdrounded-xl border-m-orange-l/20 shadow-m-orange-l/50' => true,
                ])>

                    <div class="flex flex-col gap-4 lg:gap-2 2xl:gap-4">

                        <!-- Search -->
                        <x-input.group inline label="{{ __('fields.search') }}" for='searchQuery' :error="$errors->first('searchQuery')">

                            <div class="flex items-center">
                                <x-jet-input id="searchQuery" wire:model.lazy='searchQuery' class="block w-full h-11"
                                    type="text" name="searchQuery"
                                    placeholder="{{ __('placeholders.search-by-name') }}" :value="old('searchQuery')" />


                                <x-jet-button class="py-4 overflow-visible rounded-full">
                                    <span class="mx-auto">
                                        <x-icons.search />
                                    </span>
                                </x-jet-button>

                            </div>

                        </x-input.group>

                        <!-- Sorting -->
                        <x-input.group inline label="{{ __('fields.sorting') }}" for=''>

                            <!-- Filter Buttons -->
                            <div class="flex items-center gap-4 sm:justify-center">

                                <x-buttons.filter wire:click="sortBy('created_at')" :selected="$field == 'created_at'"
                                    :isAscending="$direction == 'asc'">
                                    {{ __('fields.created-at') }}
                                </x-buttons.filter>

                                <x-buttons.filter wire:click="sortBy('name')" :selected="$field == 'name'" :isAscending="$direction == 'asc'">
                                    {{ __('fields.name') }}
                                </x-buttons.filter>

                                <x-buttons.filter wire:click="sortBy('costPrice')" :selected="$field == 'costPrice'"
                                    :isAscending="$direction == 'asc'">
                                    {{ __('fields.cost-price') }}
                                </x-buttons.filter>

                                <x-buttons.filter wire:click="sortBy('retailPrice')" :selected="$field == 'retailPrice'"
                                    :isAscending="$direction == 'asc'">
                                    {{ __('fields.retail-price') }}
                                </x-buttons.filter>

                                <x-buttons.filter wire:click="sortBy('supplier_id')" :selected="$field == 'supplier_id'"
                                    :isAscending="$direction == 'asc'">
                                    {{ __('fields.supplier') }}
                                </x-buttons.filter>

                                <x-buttons.filter wire:click="sortBy('category_id')" :selected="$field == 'category_id'"
                                    :isAscending="$direction == 'asc'">
                                    {{ __('fields.category') }}
                                </x-buttons.filter>

                            </div>

                        </x-input.group>

                    </div>

                </div>

                <!-- Add & Edit & Restock (not:sm)-->
                <div x-data="{ show: @entangle('showRestock') }"
                    class="flex flex-col w-full h-auto gap-4 px-8 py-4 my-auto overflow-y-auto transition delay-100 bg-white border shadow-md lg:px-4 lg:py-5 2xl:px-8 2xl:py-10 rounded-xl border-m-orange-l/20 shadow-m-orange-l/50">

                    <div class="flex items-center justify-start gap-4">

                        <x-buttons.switch title="{{ __('fields.add-edit') }}"
                            wire:click="$toggle('showRestock', false)"  class="flex items-center gap-2"
                            :disable='$showRestock'>
                            <x-icons.add-edit />
                        </x-buttons.switch>

                        <script src="{{ asset('js/onscan.js') }}"></script>

                        <script>
                            var showRestock = {!! json_encode($showRestock) !!};
                            var applyScanner = {!! json_encode($applyScanner) !!};
                            onScan.attachTo(document, {
                                suffixKeyCodes: [13], // enter-key expected at the end of a scan
                                reactToPaste: true, // Compatibility to built-in scanners in paste-mode (as opposed to keyboard-mode)
                                onScan: function(sCode, iQty) { // Alternative to document.addEventListener('scan')
                                    document.getElementById("barcodeId").value = sCode;
                                    if (!showRestock && !applyScanner) {
                                        Livewire.emit('add', sCode);

                                    } else {
                                        console.log("2")
                                        Livewire.emit('edit', sCode);
                                    }
                                },
                            });
                        </script>

                        <x-buttons.switch title="{{ __('fields.restock') }}" wire:click="$toggle('showRestock', true)"
                            class="flex items-center gap-2" :disable='!$showRestock' >
                            <x-icons.restock  />
                        </x-buttons.switch>

                    </div>

                    <!-- RESTOCK SECTION -->
                    <div x-show='show' x-transition:enter="scale-transform transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -scale-y-4"
                        x-transition:enter-end="opacity-100 transform -scale-y-2"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-end="opacity-0 transform scale-y-3" class="flex flex-col gap-4">

                        <div class="flex flex-col gap-6 2xl:gap-6 lg:gap-4">

                            <x-input.group inline for="selectedProductId" label="{{ __('fields.product') }}"
                                :error="$errors->first('selectedProductId')">

                                <x-input.select id="selectedProductId" placeholder="{{ __('fields.select-product') }}"
                                    wire:model.defer="selectedProductId">
                                    @foreach ($products as $key => $product)
                                        <option value="{{ $product->id }}">
                                            {{ \App\Util\Formatting::formatInThreeDigits($key + 1) . ' - ' . $product->name . ' - ' . $product->supplierNameAndCompany }}
                                        </option>
                                    @endforeach
                                </x-input.select>

                            </x-input.group>

                            <x-input.group inline label="{{ __('fields.stock') }}" for='restock' :error="$errors->first('restock')">

                                <x-jet-input wire:model.defer='restock' id="restock" class="block w-full"
                                    type="text" name="restock" placeholder="{{ __('placeholders.enter-stock') }}"
                                    :value="old('restock')" />

                            </x-input.group>

                        </div>

                        <div class="flex justify-end gap-4 pt-4">

                            <x-jet-button wire:click='saveRestock' class="p-2 w-28">
                                <span class="mx-auto">
                                    {{ __('fields.save') }}
                                </span>
                            </x-jet-button>

                            <x-jet-secondary-button wire:click='resetRestock' class="p-2 w-28">
                                <span class="mx-auto">
                                    {{ __('fields.cancel') }}
                                </span>
                            </x-jet-secondary-button>

                        </div>

                    </div>

                    <!-- ADD EDIT SECTION -->
                    <div x-show='!show' x-transition:enter="scale-transform transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -scale-y-2"
                        x-transition:enter-end="opacity-100 transform scale-y-0"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-end="opacity-0 transform -scale-y-3" class="flex flex-col gap-4">

                        <div class="flex gap-6 lg:gap-4 2xl:gap-6">

                            <!-- File Upload -->
                            <x-file-upload id="product.photo" wire:model='photo' :error="$errors->first('photo')">

                                <span wire:loading.class='hidden' wire:target='photo'>
                                    <img class="w-24 h-24 border rounded-full shadow-sm border-m-orange shadow-m-orange-l lg:w-28 lg:h-28 2xl:h-32 2xl:w-32"
                                        src="{{ isset($photo) ? $photo->temporaryUrl() : (isset($photoUrl) ? $photoUrl : asset('img/avatars/product.png')) }}">
                                </span>

                                <span wire:loading wire:target='photo'>
                                    <img class="w-24 h-24 border rounded-full shadow-sm border-m-orange shadow-m-orange-l lg:w-28 lg:h-28 2xl:h-32 2xl:w-32"
                                        src="
                                        {{ asset('img/loading.gif') }}">
                                </span>

                            </x-file-upload>

                            <!-- Product Info -->
                            <div class="flex flex-col flex-grow gap-4 2xl:gap-4 lg:gap-2">

                                <div>
                                    @if (!$showEdit)
                                        <x-input.group inline label="{{ __('fields.Barcode') }}"
                                            for='editing.barcodeId' :error="$errors->first('editing.barcodeId')">

                                            <x-jet-input wire:model.defer='editing.barcodeId' id="editing.barcodeId"
                                                class="block w-full" type="text" name="editing.barcodeId"
                                                placeholder="{{ __('placeholders.Barcode') }}" :value="old('editing.barcodeId')" />

                                        </x-input.group>
                                    @endif

                                </div>

                                <div class="hidden">
                                    <x-input.group inline label="{{ __('fields.Barcode') }}" for='barcodeId'
                                        :error="$errors->first('barcodeId')">

                                        <x-jet-input wire:model.defer='barcodeId' id="barcodeId" class="block w-full"
                                            type="text" name="barcodeId"
                                            placeholder="{{ __('placeholders.Barcode') }}" :value="old('barcodeId')" />
                                    </x-input.group>
                                </div>

                                <x-input.group inline label="{{ __('fields.name') }}" for='product.name'
                                    :error="$errors->first('editing.name')">

                                    <x-jet-input wire:model.defer='editing.name' id="product.name"
                                        class="block w-full" type="text" name="editing.name"
                                        placeholder="{{ __('placeholders.enter-name') }}" :value="old('editing.name')" />

                                </x-input.group>

                                <x-input.group inline for="product.supplier_id" label="{{ __('fields.supplier') }}"
                                    :error="$errors->first('editing.supplier_id')">

                                    <x-input.select id="product.supplier_id"
                                        placeholder="{{ __('fields.select-supplier') }}"
                                        wire:model.defer="editing.supplier_id">
                                        @foreach ($suppliers as $key => $supplier)
                                            <option value="{{ $supplier->id }}">
                                                {{ \App\Util\Formatting::formatInTwoDigits($key + 1) . ' - ' . $supplier->nameAndCompany }}
                                            </option>
                                        @endforeach
                                    </x-input.select>

                                </x-input.group>

                                <x-input.group inline for="product.category_id" label="{{ __('fields.category') }}"
                                    :error="$errors->first('editing.category_id')">

                                    <x-input.select id="product.category_id"
                                        placeholder="{{ __('fields.select-category') }}"
                                        wire:model.defer="editing.category_id">
                                        @foreach ($categories as $key => $category)
                                            <option value="{{ $category->id }}">
                                                {{ \App\Util\Formatting::formatInTwoDigits($key + 1) . ' - ' . $category->name }}
                                            </option>
                                        @endforeach
                                    </x-input.select>

                                </x-input.group>

                                <x-input.group inline label="{{ __('fields.quantity') }}" for='product.quantity'
                                    :error="$errors->first('editing.quantity')">

                                    <x-jet-input wire:model.defer='editing.quantity' id="product.quantity"
                                        class="block w-full" type="text" name="editing.quantity"
                                        placeholder="{{ __('placeholders.enter-quantity') }}" :value="old('editing.quantity')" />

                                </x-input.group>

                                <x-input.group inline label="{{ __('fields.cost-price') }}" for='product.costPrice'
                                    :error="$errors->first('editing.costPrice')">

                                    <x-jet-input wire:model.defer='editing.costPrice' id="product.costPrice"
                                        class="block w-full" type="text" name="editing.costPrice"
                                        placeholder="{{ __('placeholders.enter-cost-price') }}" :value="old('editing.costPrice')" />

                                </x-input.group>

                                <x-input.group inline label="{{ __('fields.retail-price') }}"
                                    for='product.retail-price' :error="$errors->first('editing.retailPrice')">

                                    <x-jet-input wire:model.defer='editing.retailPrice' id="product.retail-price"
                                        class="block w-full" type="text" name="editing.retail-price"
                                        placeholder="{{ __('placeholders.enter-retail-price') }}"
                                        :value="old('editing.retail-price')" />

                                </x-input.group>

                            </div>
                        </div>
                        <div class="flex justify-end gap-4 pt-4">

                            <x-jet-button wire:click='saveProduct' class="p-2 w-28">
                                <span class="mx-auto">
                                    {{ __('fields.save') }}
                                </span>
                            </x-jet-button>

                            <x-jet-secondary-button wire:click='resetProduct' class="p-2 w-28">
                                <span class="mx-auto">
                                    {{ __('fields.cancel') }}
                                </span>
                            </x-jet-secondary-button>

                        </div>
                    </div>


                </div>

            </div>

        </div>

    </div>


    <!-- Modals -->
    <x-modals.confirmation action='deleteProduct' model='showDelete' title="{{ __('fields.delete-product') }}" />

    <x-modals.content action='saveProduct' model='showEditModal' title="{{ __('fields.edit-product') }}">

        <x-file-upload id="product.photo" wire:model='photo' :error="$errors->first('photo')">

            <span wire:loading.class='hidden' wire:target='photo'>
                <img class="w-24 h-24 border rounded-full shadow-sm border-m-orange shadow-m-orange-l md:h-32 md:w-32"
                    src="
                                                            {{ isset($photo) ? $photo->temporaryUrl() : (isset($photoUrl) ? $photoUrl : asset('img/avatars/product.png')) }}">

            </span>

            <span wire:loading wire:target='photo'>
                <img class="w-24 h-24 border rounded-full shadow-sm border-m-orange shadow-m-orange-l md:h-32 md:w-32"
                    src="
                    {{ asset('img/loading.gif') }}">
            </span>

        </x-file-upload>

        <x-input.group inline label="{{ __('fields.name') }}" for='product.name' :error="$errors->first('editing.name')">

            <x-jet-input wire:model.defer='editing.name' id="product.name" class="block w-full" type="text"
                name="editing.name" placeholder="{{ __('placeholders.enter-name') }}" :value="old('editing.name')" />

        </x-input.group>

        <x-input.group inline for="product.supplier_id" label="{{ __('fields.supplier') }}" :error="$errors->first('editing.supplier_id')">

            <x-input.select id="product.supplier_id" placeholder="{{ __('fields.select-supplier') }}"
                wire:model.defer="editing.supplier_id">
                @foreach ($suppliers as $key => $supplier)
                    <option value="{{ $supplier->id }}">
                        {{ \App\Util\Formatting::formatInTwoDigits($key + 1) . ' - ' . $supplier->nameAndCompany }}
                    </option>
                @endforeach
            </x-input.select>

        </x-input.group>




        <x-input.group inline for="product.category_id" label="{{ __('fields.category') }}" :error="$errors->first('editing.category_id')">

            <x-input.select id="product.category_id" placeholder="{{ __('fields.select-category') }}"
                wire:model.defer="editing.category_id">
                @foreach ($categories as $key => $category)
                    <option value="{{ $category->id }}">
                        {{ \App\Util\Formatting::formatInTwoDigits($key + 1) . ' - ' . $category->name }}
                    </option>
                @endforeach
            </x-input.select>

        </x-input.group>



        <x-input.group inline label="{{ __('fields.quantity') }}" for='product.quantity' :error="$errors->first('editing.quantity')">

            <x-jet-input wire:model.defer='editing.quantity' id="product.quantity" class="block w-full"
                type="text" name="editing.quantity" placeholder="{{ __('placeholders.enter-quantity') }}"
                :value="old('editing.quantity')" />

        </x-input.group>

        <x-input.group inline label="{{ __('fields.cost-price') }}" for='product.costPrice' :error="$errors->first('editing.costPrice')">

            <x-jet-input wire:model.defer='editing.costPrice' id="product.costPrice" class="block w-full"
                type="text" name="editing.costPrice" placeholder="{{ __('placeholders.enter-cost-price') }}"
                :value="old('editing.costPrice')" />

        </x-input.group>

        <x-input.group inline label="{{ __('fields.retail-price') }}" for='product.retail-price' :error="$errors->first('editing.retailPrice')">

            <x-jet-input wire:model.defer='editing.retailPrice' id="product.retail-price" class="block w-full"
                type="text" name="editing.retail-price" placeholder="{{ __('placeholders.enter-retail-price') }}"
                :value="old('editing.retail-price')" />

        </x-input.group>

    </x-modals.content>

    <x-modals.content action='saveRestock' model='showRestockModal' title="{{ __('fields.edit-stock') }}">

        <x-input.group inline for="selectedProductId" label="{{ __('fields.product') }}" :error="$errors->first('selectedProductId')">

            <x-input.select id="selectedProductId" placeholder="{{ __('fields.select-product') }}"
                wire:model.defer="selectedProductId">
                @foreach ($products as $key => $product)
                    <option value="{{ $product->id }}">
                        {{ \App\Util\Formatting::formatInThreeDigits($key + 1) . ' - ' . $product->name . ' - ' . $product->supplierNameAndCompany }}
                    </option>
                @endforeach
            </x-input.select>

        </x-input.group>

        <x-input.group inline label="{{ __('fields.stock') }}" for='restock' :error="$errors->first('restock')">

            <x-jet-input wire:model.defer='restock' id="restock" class="block w-full" type="text"
                name="restock" placeholder="{{ __('placeholders.enter-stock') }}" :value="old('restock')" />

        </x-input.group>

    </x-modals.content>




</div>
