<div>

    <div
        class="flex flex-col w-full gap-4 p-4 my-auto overflow-y-auto bg-white border shadow-md 2xl:p-4 lg:p-2 2xl:gap-2 lg:gap-2 rounded-xl border-m-orange-l/20 shadow-m-orange-l/50">

        <x-input.group inline label="{{ __('fields.search-client') }}" for='searchQuery' :error="$errors->first('searchQuery')">

            <div class="flex items-center gap-2">
                <div class="flex flex-col w-full gap-4 2xl:gap-2 lg:gap-2">

                    <div class="flex items-center w-full gap-2">

                        <span>
                            <x-input.radio wire:model='searchType' name="client.search.type" value='0' />
                        </span>

                        <span class="w-full">
                            <x-jet-input id="client.search.name" wire:model.debounce.400ms='searchName'
                                class="w-full disabled:opacity-30" type="text" name="client.search.name"
                                placeholder="{{ __('placeholders.search-by-name') }}" :value="old('searchQuery')"
                                :disabled="$searchType == '1'" />
                        </span>

                    </div>

                    <div class="flex items-center w-full gap-2">

                        <span>
                            <x-input.radio wire:model='searchType' name="client.search.type" value='1' />
                        </span>

                        <span class="w-full">
                            <x-jet-input id="client.search.phone" wire:model.debounce.400ms='searchPhone'
                                class="w-full disabled:opacity-30" type="text" name="client.search.phone"
                                placeholder="{{ __('placeholders.search-by-phone') }}" :value="old('searchQuery')"
                                :disabled="$searchType == '0'" />
                        </span>

                    </div>

                </div>

                <x-jet-button class="p-3 overflow-visible rounded-full" wire:click='showAddModal'>
                    <span class="mx-auto">
                        <x-icons.person-add />
                    </span>
                </x-jet-button>

            </div>

        </x-input.group>

        <hr class="w-full text-m-orange">

        <div wire:loading.class='opacity-50'
            class="flex flex-col w-full gap-4 p-2 my-auto overflow-y-auto transition delay-100 2xl:h-24 lg:h-32 ">
            @forelse ($clients as $key => $client)
                <div wire:key='wkw-{{ $key }}'>
                    <x-cards.client-simple id="{{ $client->id }}" name="{{ $client->name }}"
                        phone="{{ $client->phone }}" :selected='$client->id == $selectedClient->id' />
                </div>
            @empty
                <div class="flex items-center justify-center flex-grow">

                    <span class="text-m-blue">
                        <x-icons.info size="24" />
                    </span>

                </div>
            @endforelse

        </div>

    </div>

    <!-- Add Modal -->
    <x-modals.client-editing />

</div>
