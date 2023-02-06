<div>

    <!-- Header -->
    <x-page.header>

        <x-slot name='header'>
            {{ __('fields.expenses') }}
        </x-slot>

        <x-slot name='actions'>

            <x-buttons.rounded wire:click='showAddModal'>
                <span>
                    <x-icons.plus />
                </span>
            </x-buttons.rounded>

            <x-buttons.rounded wire:click='showRentModal'>
                <span>
                    <x-icons.rent />
                </span>
            </x-buttons.rounded>

            <x-buttons.rounded wire:click='showWorkerModal'>
                <span>
                    <x-icons.worker />
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
                <span class="w-full" x-data>
                    <x-jet-input x-ref="sm" x-init="new Pikaday({
                        field: $refs.sm,
                        format: 'DD/MM/YYYY'
                    });" id="searchQuery-sm" wire:model.lazy='searchQuery'
                        class="block w-full h-11" type="text" name="searchQuery" placeholder="dd/mm/yyyy"
                        :value="old('searchQuery')" />
                </span>
            @else
                <div class="flex flex-col items-center justify-between gap-4">

                    <div class="flex items-center justify-center gap-4">
                        <x-buttons.filter wire:click="sortBy('created_at')" :selected="$field == 'created_at'" :isAscending="$direction == 'asc'">
                            {{ __('fields.created-at') }}
                        </x-buttons.filter>

                        <x-buttons.filter wire:click="sortBy('user_id')" :selected="$field == 'user_id'" :isAscending="$direction == 'asc'">
                            {{ __('fields.user') }}
                        </x-buttons.filter>

                        <x-buttons.filter wire:click="sortBy('branch_id')" :selected="$field == 'branch_id'" :isAscending="$direction == 'asc'">
                            {{ __('fields.branch') }}
                        </x-buttons.filter>
                    </div>

                </div>
            @endif

        </x-slot>

    </x-page.header>

    <!-- Body -->
    <div class="py-2 lg:py-4 2xl:py-4">

        <div class="flex gap-4 px-4 mx-auto md:px-10 max-h-[71vh] md:max-h-[81vh] min-h-[71vh] md:min-h-[81vh]">

            <!-- Expenses List -->
            <div wire:loading.class='opacity-50' @class([
                'opacity-50' => $showEdit,
                'flex flex-col w-full gap-4 p-0 lg:p-4 overflow-y-auto transition delay-100 bg-transparent lg:bg-white lg:border lg:shadow-md lg:shadow-m-orange-l/50 lg:border-m-orange-l/20 rounded-xl lg:w-1/2' => true,
            ])>
                @forelse ($expenses as $key => $expense)
                    <div wire:key='wkw-{{ $key }}'>
                        @php
                            $decodedMetaData = $expense->decodedMetaData;
                        @endphp
                        <x-cards.expense id="{{ $expense->id }}" createdAtDate="{{ $expense->createdAtDate }}"
                            userName="{{ $expense->user->name }}" branchName="{{ $expense->branch->name }}"
                            expenseName="{{ $expense->getName($decodedMetaData) }}"
                            expenseCostInCurrency="{{ $expense->getCostInCurrency($decodedMetaData) }}"
                            editAction='showEdit' deleteAction='showDelete' />
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
            <div class="flex-col items-center flex-grow hidden w-1/2 gap-4 overflow-hidden lg:gap-2 2xl:gap-4 lg:flex">

                <!-- Search & Sorting -->
                <div @class([
                    'opacity-50' => $showEdit,
                    'w-full px-8 py-10 lg:px-4 lg:py-5 2xl:px-8 2xl:py-10 transition delay-100 my-auto bg-white border shadow-md rounded-xl border-m-orange-l/20 shadow-m-orange-l/50' => true,
                ])>

                    <div class="flex flex-col gap-4 lg:gap-2 2xl:gap-4">

                        <!-- Search -->
                        <x-input.group inline label="{{ __('fields.search') }}" for='searchQuery' :error="$errors->first('searchQuery')">

                            <div class="flex items-center" x-data>
                                <x-jet-input x-ref="lg" x-init="new Pikaday({
                                    field: $refs.lg,
                                    format: 'DD/MM/YYYY'
                                });" id="searchQuery"
                                    wire:model.lazy='searchQuery' class="block w-full h-11" type="text"
                                    name="searchQuery" placeholder="dd/mm/yyyy" :value="old('searchQuery')" />

                                <x-jet-button wire:click="$set('searchQuery', '')"
                                    class='py-4 overflow-visible rounded-full' :disabled="empty($searchQuery)">

                                    <span class="mx-auto">
                                        <x-icons.close />
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

                                <x-buttons.filter wire:click="sortBy('user_id')" :selected="$field == 'user_id'" :isAscending="$direction == 'asc'">
                                    {{ __('fields.user') }}
                                </x-buttons.filter>

                                <x-buttons.filter wire:click="sortBy('branch_id')" :selected="$field == 'branch_id'"
                                    :isAscending="$direction == 'asc'">
                                    {{ __('fields.branch') }}
                                </x-buttons.filter>

                            </div>

                        </x-input.group>

                    </div>

                </div>

                <!-- TYPE 0 - [NAME / COST]  (not:sm)-->
                <!-- TYPE 1 - [COST]  (not:sm)-->
                <!-- TYPE 2 - [WORKER / COST]  (not:sm)-->
                <div x-data="{ type: @entangle('type') }"
                    class="flex flex-col w-full h-auto gap-4 px-8 py-10 my-auto overflow-y-auto transition delay-100 bg-white border shadow-md lg:px-4 2xl:px-8 lg:py-5 2xl:py-10 rounded-xl border-m-orange-l/20 shadow-m-orange-l/50">
                    <div class="flex items-center justify-start gap-4">

                        <x-buttons.switch title="{{ __('fields.add-edit') }}" wire:click="$set('type', '0')"
                            class="flex items-center gap-2" :disable='$type != 0'>
                            <x-icons.add-edit />
                        </x-buttons.switch>

                        <x-buttons.switch title="{{ __('fields.rent') }}" wire:click="$set('type', '1')"
                            class="flex items-center gap-2" :disable='$type != 1'>
                            <x-icons.rent />
                        </x-buttons.switch>

                        <x-buttons.switch title="{{ __('fields.worker') }}" wire:click="$set('type', '2')"
                            class="flex items-center gap-2" :disable='$type != 2'>
                            <x-icons.worker />
                        </x-buttons.switch>

                    </div>

                    <!-- ADD / EDIT SECTION -->
                    <div x-show='type == 0'
                        x-transition:enter="scale-transform transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -scale-y-4"
                        x-transition:enter-end="opacity-100 transform -scale-y-2"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-end="opacity-0 transform scale-y-3" class="flex flex-col gap-4">

                        <div class="flex gap-6">

                            <div class="flex flex-col flex-grow gap-4">

                                <x-input.group inline label="{{ __('fields.name') }}" for='expense.name'
                                    :error="$errors->first('editing.metaData.name')">

                                    <x-jet-input wire:model.defer='editing.metaData.name' id="expense.name"
                                        class="block w-full" type="text" name="expense.name"
                                        placeholder="{{ __('placeholders.enter-name') }}" :value="old('editing.metaData.name')" />

                                </x-input.group>

                                <x-input.group inline label="{{ __('fields.cost') }}" for='expense.cost'
                                    :error="$errors->first('editing.metaData.cost')">

                                    <x-jet-input wire:model.defer='editing.metaData.cost' id="expense.cost"
                                        class="block w-full" type="text" name="expense.cost"
                                        placeholder="{{ __('placeholders.enter-cost-price') }}" :value="old('editing.metaData.cost')" />

                                </x-input.group>

                            </div>

                        </div>

                        <div class="flex justify-end gap-4 pt-4">

                            <x-jet-button wire:click='saveExpense' class="p-2 w-28">
                                <span class="mx-auto">
                                    {{ __('fields.save') }}
                                </span>
                            </x-jet-button>

                            <x-jet-secondary-button wire:click='resetExpense' class="p-2 w-28">
                                <span class="mx-auto">
                                    {{ __('fields.cancel') }}
                                </span>
                            </x-jet-secondary-button>

                        </div>

                    </div>

                    <!-- RENT SECTION -->
                    <div x-show='type == 1'
                        x-transition:enter="scale-transform transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -scale-y-4"
                        x-transition:enter-end="opacity-100 transform -scale-y-2"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-end="opacity-0 transform scale-y-3" class="flex flex-col gap-4">

                        <div class="flex gap-6">

                            <div class="flex flex-col flex-grow gap-4">

                                <x-input.group inline label="{{ __('fields.cost') }}" for='expense.cost'
                                    :error="$errors->first('editing.metaData.cost')">

                                    <x-jet-input wire:model.defer='editing.metaData.cost' id="expense.cost"
                                        class="block w-full" type="text" name="expense.cost"
                                        placeholder="{{ __('placeholders.enter-cost-price') }}" :value="old('editing.metaData.cost')" />

                                </x-input.group>

                            </div>

                        </div>

                        <div class="flex justify-end gap-4 pt-4">

                            <x-jet-button wire:click='saveExpense' class="p-2 w-28">
                                <span class="mx-auto">
                                    {{ __('fields.save') }}
                                </span>
                            </x-jet-button>

                            <x-jet-secondary-button wire:click='resetExpense' class="p-2 w-28">
                                <span class="mx-auto">
                                    {{ __('fields.cancel') }}
                                </span>
                            </x-jet-secondary-button>

                        </div>

                    </div>

                    <!-- WORKER SECTION -->
                    <div x-show='type == 2'
                        x-transition:enter="scale-transform transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -scale-y-4"
                        x-transition:enter-end="opacity-100 transform -scale-y-2"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-end="opacity-0 transform scale-y-3" class="flex flex-col gap-4">

                        <div class="flex gap-6">

                            <div class="flex flex-col flex-grow gap-4">

                                <x-input.group inline for="expense.worker_id" label="{{ __('fields.worker') }}"
                                    :error="$errors->first('editing.metaData.worker_id')">

                                    <x-input.select id="expense.worker_id"
                                        placeholder="{{ __('fields.select-worker') }}"
                                        wire:model.defer="editing.metaData.worker_id">
                                        @foreach ($workers as $key => $worker)
                                            <option value="{{ $worker->id }}">
                                                {{ $worker->name }}
                                            </option>
                                        @endforeach
                                    </x-input.select>

                                </x-input.group>

                                <x-input.group inline label="{{ __('fields.cost') }}" for='expense.cost'
                                    :error="$errors->first('editing.metaData.cost')">

                                    <x-jet-input wire:model.defer='editing.metaData.cost' id="expense.cost"
                                        class="block w-full" type="text" name="expense.cost"
                                        placeholder="{{ __('placeholders.enter-cost-price') }}" :value="old('editing.metaData.cost')" />

                                </x-input.group>

                            </div>

                        </div>

                        <div class="flex justify-end gap-4 pt-4">

                            <x-jet-button wire:click='saveExpense' class="p-2 w-28">
                                <span class="mx-auto">
                                    {{ __('fields.save') }}
                                </span>
                            </x-jet-button>

                            <x-jet-secondary-button wire:click='resetExpense' class="p-2 w-28">
                                <span class="mx-auto">
                                    {{ __('fields.cancel') }}
                                </span>
                            </x-jet-secondary-button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Modals -->
        <x-modals.confirmation action='deleteExpense' model='showDelete' title="{{ __('fields.delete-expense') }}" />

        <x-modals.content action='saveExpense' model='showEditModal' title="{{ __('fields.edit-expense') }}">

            <x-input.group inline label="{{ __('fields.name') }}" for='expense.name' :error="$errors->first('editing.metaData.name')">

                <x-jet-input wire:model.defer='editing.metaData.name' id="expense.name" class="block w-full"
                    type="text" name="expense.name" placeholder="{{ __('placeholders.enter-name') }}"
                    :value="old('editing.metaData.name')" />

            </x-input.group>

            <x-input.group inline label="{{ __('fields.cost') }}" for='expense.cost' :error="$errors->first('editing.metaData.cost')">

                <x-jet-input wire:model.defer='editing.metaData.cost' id="expense.cost" class="block w-full"
                    type="text" name="expense.cost" placeholder="{{ __('placeholders.enter-cost-price') }}"
                    :value="old('editing.metaData.cost')" />

            </x-input.group>

        </x-modals.content>

        <x-modals.content action='saveExpense' model='showRentModal' title="{{ __('fields.edit-rent') }}">

            <x-input.group inline label="{{ __('fields.cost') }}" for='expense.cost' :error="$errors->first('editing.metaData.cost')">

                <x-jet-input wire:model.defer='editing.metaData.cost' id="expense.cost" class="block w-full"
                    type="text" name="expense.cost" placeholder="{{ __('placeholders.enter-cost-price') }}"
                    :value="old('editing.metaData.cost')" />

            </x-input.group>

        </x-modals.content>

        <x-modals.content action='saveExpense' model='showWorkerModal' title="{{ __('fields.edit-worker') }}">

            <x-input.group inline for="expense.worker_id" label="{{ __('fields.worker') }}" :error="$errors->first('editing.metaData.worker_id')">

                <x-input.select id="expense.worker_id" placeholder="{{ __('fields.select-worker') }}"
                    wire:model.defer="editing.metaData.worker_id">
                    @foreach ($workers as $key => $worker)
                        <option value="{{ $worker->id }}">
                            {{ $worker->name }}
                        </option>
                    @endforeach
                </x-input.select>

            </x-input.group>

            <x-input.group inline label="{{ __('fields.cost') }}" for='expense.cost' :error="$errors->first('editing.metaData.cost')">

                <x-jet-input wire:model.defer='editing.metaData.cost' id="expense.cost" class="block w-full"
                    type="text" name="expense.cost" placeholder="{{ __('placeholders.enter-cost-price') }}"
                    :value="old('editing.metaData.cost')" />

            </x-input.group>

        </x-modals.content>

        @push('styles')
            <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
        @endpush

        @push('scripts')
            <script src="https://unpkg.com/moment"></script>
            <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
        @endpush

    </div>
