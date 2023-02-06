<div>

    <div class="flex items-center justify-center flex-grow h-[80vh] lg:hidden">

        <span class="text-m-blue">
            <x-icons.info size="24" />
        </span>

    </div>

    <div class="hidden py-2 lg:block lg:py-4 2xl:py-4">

        <div class="flex gap-4 px-4 mx-auto lg:px-4 2xl:px-10 max-h-[71vh] md:max-h-[81vh] min-h-[71vh] md:min-h-[81vh]">

            <!-- Main -->
            <div class="flex flex-col items-start w-3/4 gap-8 lg:gap-2 2xl:gap-2">

                <!-- Services Section -->
                <div
                    class="w-full p-4 bg-white border shadow-md 2xl:p-4 lg:p-2 rounded-xl border-m-orange-l/20 shadow-m-orange-l/50">


                        @if (!$PickProducts)

                            @livewire('admin.dashboard.categories')

                        @else

                            @livewire('admin.dashboard.products')

                        @endif

                </div>

                <!-- Barcode Input -->
                <div class="flex justify-end w-full ">
                    <div class="flex items-center justify-between gap-2">

                        <div>
                            <x-jet-input id="product.add" wire:model.defer='typedBarcodeId'
                                class="w-full disabled:opacity-30" type="text" name="product.add"
                                placeholder="{{ __('placeholders.add-product') }}" :value="old('typedBarcodeId')" />
                        </div>

                        <div>
                            <x-buttons.rounded wire:click="addProductWithText" title="{{ __('fields.discount') }}">
                                <x-icons.plus />
                            </x-buttons.rounded>
                        </div>

                    </div>
                </div>

                <!-- Summary Table -->
                <div class="w-full overflow-y-auto shadow-md rounded-xl border-m-orange-l/20 shadow-m-orange-l/50">

                    <x-table>

                        <x-slot name="head">

                            <x-table.heading>#</x-table.heading>

                            <x-table.heading>{{ __('fields.item') }}</x-table.heading>

                            <x-table.heading>{{ __('fields.price') }}</x-table.heading>

                            <x-table.heading>{{ __('fields.quantity') }}</x-table.heading>

                            <x-table.heading>{{ __('fields.subtotal') }}</x-table.heading>

                            <x-table.heading>{{ __('fields.operations') }}</x-table.heading>

                        </x-slot>

                        <x-slot name="body">
                            @forelse ($itemsList as $key => $item)
                                <x-table.row wire:key='t-r-{{ $key }}' wire:loading.class.delay="opacity-50"
                                    class="transition delay-100">

                                    <x-table.cell>{{ ++$loop->index }}</x-table.cell>

                                    <x-table.cell>{{ $item['name'] }}</x-table.cell>

                                    <x-table.cell>{{ $item['retailPriceInCurrency'] }}</x-table.cell>

                                    <x-table.cell>



                                        <div class="flex items-center justify-start gap-2">

                                            <x-buttons.rounded wire:click="decreaseQuantity('{{ $key }}')"
                                                 class="w-10 h-10 p-1">
                                                <x-icons.minus />
                                            </x-buttons.rounded>

                                            {{ \App\Util\Formatting::formatInTwoDigits($item['quantity']) }}

                                            <x-buttons.rounded wire:click="increaseQuantity('{{ $key }}')"
                                                 class="w-10 h-10 p-1">
                                                <x-icons.plus />
                                            </x-buttons.rounded>

                                        </div>

                                    </x-table.cell>

                                    <x-table.cell>
                                        {{ \App\Util\Formatting::formatInCurrency($item['quantity'] * $item['retailPrice']) }}
                                    </x-table.cell>

                                    <x-table.cell>

                                        <button wire:click="showDeleteItem('{{ $key }}')"
                                            class="p-2 text-white transition delay-100 border rounded-full shadow-2xl cursor-pointer hover:border-white border-m-orange hover:shadow-m-orange-d bg-m-blue hover:text-m-orange-l"
                                            title="{{ __('fields.delete') }}">
                                            <x-icons.delete />
                                        </button>

                                    </x-table.cell>

                                </x-table.row>
                            @empty
                                <x-table.row wire:loading.class.delay="opacity-50" class="transition delay-100">

                                    <x-table.cell colspan="6">

                                        <div class="flex items-center justify-center flex-grow">

                                            <span>
                                                <img class="w-24 h-24 border-2 rounded-full shadow-xl 2xl:w-24 2xl:h-24 lg:w-20 lg:h-20 border-m-blue"
                                                    src="{{ asset('img/qr-scan.gif') }}" alt="qr-scanner-gif">
                                            </span>

                                        </div>

                                    </x-table.cell>

                                </x-table.row>
                            @endforelse

                        </x-slot>

                    </x-table>

                </div>

            </div>

            <!-- SideBar -->
            <div class="flex flex-col items-center justify-center w-1/4 gap-8 lg:gap-2 2xl:gap-2" style="height: fit-content">

                <!-- Finish / Discount / Cancel -->
                <div
                    class="flex items-center justify-center w-full gap-4 px-6 transition delay-100 bg-white border shadow-md 2xl:px-6 2xl:py-2 2xl:gap-4 lg:gap-2 rounded-xl border-m-orange-l/20 shadow-m-orange-l/50">

                    <x-buttons.rounded wire:click="$toggle('showCancel')" color='red-500' hover='red-700'
                        title="{{ __('fields.cancel') }}" :disabled="count($itemsList) == 0">
                        <x-icons.cancel />
                    </x-buttons.rounded>

                    <x-buttons.rounded wire:click="showDiscount" title="{{ __('fields.discount') }}"
                        :disabled="count($itemsList) == 0">
                        <x-icons.discount />
                    </x-buttons.rounded>

                    <x-buttons.rounded wire:click="$toggle('showFinish')" color='green-500' hover='green-700'
                        title="{{ __('fields.finish') }}" :disabled="count($itemsList) == 0">
                        <x-icons.cart />
                    </x-buttons.rounded>

                </div>

                <!-- Summary List -->
                <div
                    class="w-full p-4 bg-white border shadow-md 2xl:p-4 lg:p-2 rounded-xl border-m-orange-l/20 shadow-m-orange-l/50">

                    <x-input.group inline label="{{ __('fields.summary') }}" for=''>

                        <div class="flex flex-col gap-4 2xl:gap-4 lg:gap-1">

                            <!-- Subtotal -->
                            <div class="flex items-center justify-between w-full">
                                <span
                                    class="text-xl 2xl:text-xl lg:text-base text-m-blue font-roboto">{{ __('fields.subtotal') }}</span>

                                <span
                                    class="text-lg 2xl:text-lg lg:text-base font-roboto-m">{{ \App\Util\Formatting::formatInCurrency($subtotal, false) }}
                                    <span>{{ __('fields.EGP') }}</span>
                                </span>

                            </div>

                            <hr class="w-full text-m-orange">

                            <!-- Discount -->
                            <div class="flex items-center justify-between w-full">
                                <span
                                    class="text-xl 2xl:text-xl lg:text-base text-m-blue font-roboto">{{ __('fields.discount') }}</span>
                                <span class="text-lg 2xl:text-lg lg:text-base font-roboto-m text-m-red-d"><span>-</span>
                                    {{ \App\Util\Formatting::formatInCurrency($discount, false) }}
                                    <span>{{ __('fields.EGP') }}</span>
                                </span>
                            </div>

                            <hr class="w-full text-m-orange">

                            <!-- Total -->
                            <div class="flex items-center justify-between w-full py-1">

                                <span
                                    class="text-2xl 2xl:text-2xl lg:text-base text-m-orange font-roboto">{{ __('fields.total') }}</span>

                                <span
                                    class="text-xl 2xl:text-xl lg:text-base text-m-orange font-roboto-m">{{ \App\Util\Formatting::formatInCurrency($total, false) }}
                                    <span>{{ __('fields.EGP') }}</span>
                                </span>

                            </div>

                        </div>

                    </x-input.group>

                </div>

                <!-- Client Component -->
                <div class="w-full ">
                    @livewire('admin.dashboard.client')
                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('js/onscan.js') }}"></script>
    <script>

        onScan.attachTo(document, {
            suffixKeyCodes: [13],
            onScan:function(sCode, iQty){
                console.log(sCode , iQty);
                Livewire.emit('scan', sCode);
            },
        });

        window.addEventListener('openReceipt', (e) => {
            window.open(
                @js(env('APP_URL')) + `/receipts/${e.detail}`,
                "_blank"
            );

        });
    </script>

    <!-- Modals -->
    <x-modals.confirmation action='finishOrder' model='showFinish' title="{{ __('fields.finish-order') }}" />

    <x-modals.confirmation action='cancelOrder' model='showCancel' title="{{ __('fields.cancel-order') }}" />

    <x-modals.confirmation action='deleteItem' model='showDeleteItem' title="{{ __('fields.delete-item') }}" />

    <x-modals.content action='saveDiscount' model='showDiscount' title="{{ __('fields.edit-discount') }}">

        <x-input.group inline label="{{ __('fields.discount') }}" for='order.discount' :error="$errors->first('discount')">

            <x-jet-input wire:model.defer='discount' id="order.discount" class="block w-full" type="text"
                name="order.discount" placeholder="{{ __('placeholders.enter-discount') }}" :value="old('discount')" />

        </x-input.group>

    </x-modals.content>
</div>
