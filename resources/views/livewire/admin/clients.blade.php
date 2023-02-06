<div>

    <!-- Header -->
    <x-page.header>

        <x-slot name='header'>
            {{ __('fields.clients') }}
        </x-slot>

        <x-slot name='actions'>

            <x-buttons.rounded wire:click='showAddModal'>
                <span>
                    <x-icons.plus />
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
                <x-buttons.filter wire:click="sortBy('created_at')" :selected="$field == 'created_at'" :isAscending="$direction == 'asc'">
                    {{ __('fields.created-at') }}
                </x-buttons.filter>

                <x-buttons.filter wire:click="sortBy('name')" :selected="$field == 'name'" :isAscending="$direction == 'asc'">
                    {{ __('fields.name') }}
                </x-buttons.filter>
            @endif

        </x-slot>

    </x-page.header>

    <!-- Body -->
    <div class="py-2 lg:py-4 2xl:py-4">

        <div class="flex gap-4 px-4 mx-auto md:px-10 max-h-[71vh] md:max-h-[81vh] min-h-[71vh] md:min-h-[81vh]">

            <!-- Clients List -->
            <div wire:loading.class='opacity-50' @class([
                'opacity-50' => $showEdit,
                'flex flex-col w-full gap-4 p-0 lg:p-4 overflow-y-auto transition delay-100 bg-transparent lg:bg-white lg:border lg:shadow-md lg:shadow-m-orange-l/50 lg:border-m-orange-l/20 rounded-xl lg:w-1/2' => true,
            ])>

                @forelse ($clients as $key => $client)
                    <div wire:key='wkw-{{ $key }}'>
                        <x-cards.client id="{{ $client->id }}" name="{{ $client->name }}"
                            phone="{{ $client->phone }}" editAction='showEdit' deleteAction='showDelete' />
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
                    'w-full px-8 py-10 lg:px-4 lg:py-5 2xl:px-8 2xl:py-10 transition delay-100 my-auto bg-white border shadow-md rounded-xl border-m-orange-l/20 shadow-m-orange-l/50' => true,
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

                                <x-buttons.filter wire:click="sortBy('created_at')" :selected="$field == 'created_at'" :isAscending="$direction == 'asc'">
                                    {{ __('fields.created-at') }}
                                </x-buttons.filter>

                                <x-buttons.filter wire:click="sortBy('name')" :selected="$field == 'name'" :isAscending="$direction == 'asc'">
                                    {{ __('fields.name') }}
                                </x-buttons.filter>

                            </div>

                        </x-input.group>

                    </div>

                </div>

                <!-- Add & Edit (not:sm)-->
                <div
                    class="w-full px-8 py-10 my-auto bg-white border shadow-md lg:px-4 lg:py-5 2xl:px-8 2xl:py-10 rounded-xl border-m-orange-l/20 shadow-m-orange-l/50">

                    <div class="flex flex-col gap-4">

                        <x-input.group inline label="{{ __('fields.name') }}" for='client.name' :error="$errors->first('editing.name')">

                            <x-jet-input wire:model.defer='editing.name' id="client.name" class="block w-full"
                                type="text" name="editing.name" placeholder="{{ __('placeholders.enter-name') }}"
                                :value="old('editing.name')" />

                        </x-input.group>

                        <x-input.group inline label="{{ __('fields.phone') }}" for='client.phone' :error="$errors->first('editing.phone')">

                            <x-jet-input wire:model.defer='editing.phone' id="client.phone" class="block w-full"
                                type="text" name="editing.phone" placeholder="{{ __('placeholders.enter-phone') }}"
                                :value="old('editing.phone')" />

                        </x-input.group>

                        <div class="flex justify-center gap-4 pt-4">

                            <x-jet-button wire:click='saveClient' class="p-2 w-28">
                                <span class="mx-auto">
                                    {{ __('fields.save') }}
                                </span>
                            </x-jet-button>

                            <x-jet-secondary-button wire:click='resetClient' class="p-2 w-28">
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
    <x-modals.confirmation action='deleteClient' model='showDelete' title="{{ __('fields.delete-client') }}" />

    <x-modals.client-editing />

</div>