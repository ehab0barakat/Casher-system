<div >
    <div>
        <div class="flex items-center justify-between">

            <div class="flex items-center justify-center gap-2" wire:click="ShowCategories" >

                <x-icons.previous action="ShowCategories" />

                <span class="block text-sm leading-5 text-m-orange-l font-roboto-m">{{ __('fields.products') }}</span>
            </div>

            <!-- Product Search Input -->
            <div class="w-1/4">
                <x-jet-input id="product.search" wire:model.debounce.400ms='searchProduct'
                    class="w-full disabled:opacity-30" type="text" name="product.search"
                    placeholder="{{ __('placeholders.search-products') }}" :value="old('searchProduct')"/>
            </div>

        </div>

        <div class="relative mt-3 rounded-md shadow-sm">

            <div wire:loading.class.delay='opacity-50'
                class="grid grid-flow-col grid-rows-4 gap-2 pt-1 pb-2 overflow-x-auto transition delay-100 2xl:gap-2 lg:gap-2">

                @forelse ($produwcts as $key => $product)
                    <div class="" wire:key='l-s-{{ $key }}'>
                        <x-cards.product-simple id="{{ $product->id }}" name="{{ $product->name }}"
                            url="{{ $product->getPhotoOrDefaultUrlAttribute()}}"
                            addAction='AddProduct' />
                    </div>
                @empty

                    <div class="flex items-center justify-center flex-grow">

                        <span class="text-m-blue">
                            <x-icons.info size="18" />
                        </span>

                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
