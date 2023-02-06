<div>

    <!-- Header -->
    <x-page.header>

        <x-slot name='header'>
            {{ __('fields.users') }}
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
                        <x-buttons.filter wire:click="sortBy('branch_id')" :selected="$field == 'branch_id'" :isAscending="$direction == 'asc'">
                            {{ __('fields.branch') }}
                        </x-buttons.filter>

                        <x-buttons.filter wire:click="sortBy('username')" :selected="$field == 'username'" :isAscending="$direction == 'asc'">
                            {{ __('fields.username') }}
                        </x-buttons.filter>
                    </div>
                </div>
            @endif

        </x-slot>

    </x-page.header>

    <!-- Body -->
    <div class="py-2 lg:py-4 2xl:py-4">

        <div class="flex gap-4 px-4 mx-auto md:px-10 max-h-[71vh] md:max-h-[81vh] min-h-[71vh] md:min-h-[81vh]">

            <!-- Users List -->
            <div wire:loading.class='opacity-50' @class([
                'opacity-50' => $showEdit,
                'flex flex-col w-full gap-4 p-0 lg:p-4 overflow-y-auto transition delay-100 bg-transparent lg:bg-white lg:border lg:shadow-md lg:shadow-m-orange-l/50 lg:border-m-orange-l/20 rounded-xl lg:w-1/2' => true,
            ])>

                @forelse ($users as $key => $user)
                    <div wire:key='wkw-{{ $key }}'>
                        <x-cards.user id="{{ $user->id }}" name="{{ $user->name }}"
                            username="{{ $user->username }}" branch="{{ $user->branch->name }}"
                            permissions="{{ $user->permissionsInSpacedKebabCase }}" editAction='showEdit'
                            deleteAction='showDelete' />
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

                                <x-buttons.filter wire:click="sortBy('created_at')" :selected="$field == 'created_at'"
                                    :isAscending="$direction == 'asc'">
                                    {{ __('fields.created-at') }}
                                </x-buttons.filter>

                                <x-buttons.filter wire:click="sortBy('name')" :selected="$field == 'name'" :isAscending="$direction == 'asc'">
                                    {{ __('fields.name') }}
                                </x-buttons.filter>

                                <x-buttons.filter wire:click="sortBy('branch_id')" :selected="$field == 'branch_id'"
                                    :isAscending="$direction == 'asc'">
                                    {{ __('fields.branch') }}
                                </x-buttons.filter>

                                <x-buttons.filter wire:click="sortBy('username')" :selected="$field == 'username'" :isAscending="$direction == 'asc'">
                                    {{ __('fields.username') }}
                                </x-buttons.filter>

                            </div>

                        </x-input.group>

                    </div>

                </div>

                <!-- Add & Edit (not:sm)-->
                <div
                    class="w-full my-auto bg-white border shadow-md lg:overflow-y-auto lg:px-4 lg:py-5 2xl:px-8 2xl:py-10 rounded-xl border-m-orange-l/20 shadow-m-orange-l/50">

                    <div class="flex flex-col gap-4 2xl:gap-4 lg:gap-2">

                        <x-input.group inline label="{{ __('fields.name') }}" for='user.name' :error="$errors->first('editing.name')">

                            <x-jet-input wire:model.defer='editing.name' id="user.name" class="block w-full"
                                type="text" name="editing.name" placeholder="{{ __('placeholders.enter-name') }}"
                                :value="old('editing.name')" />

                        </x-input.group>

                        <x-input.group inline for="user.branch" label="{{ __('fields.branch') }}" :error="$errors->first('editing.branch_id')">

                            <x-input.select id="user.branch" placeholder="{{ __('fields.select-branch') }}"
                                wire:model.defer="editing.branch_id">
                                @foreach ($branches as $key => $branch)
                                    <option value="{{ $branch->id }}">
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </x-input.select>

                        </x-input.group>

                        <x-input.group inline label="{{ __('fields.username') }}" for='user.username'
                            :error="$errors->first('editing.username')">

                            <x-jet-input wire:model.defer='editing.username' id="user.username" class="block w-full"
                                type="text" name="editing.username"
                                placeholder="{{ __('placeholders.enter-username') }}" :value="old('editing.username')" />

                        </x-input.group>

                        <x-input.group inline
                            label="{{ $showEdit ? __('fields.change-password') : __('fields.password') }}"
                            for='user.password' :error="$errors->first('editing.beforeHashPassword')">

                            <x-jet-input wire:model.defer='editing.beforeHashPassword' id="user.password"
                                class="block w-full" type="text" name="editing.password"
                                placeholder="{{ __('placeholders.enter-password') }}" :value="old('editing.beforeHashPassword')" />

                        </x-input.group>

                        <x-input.group inline label="{{ __('fields.permissions') }}" for='' :error="$errors->first('selectedPermissions')">

                            <div class="grid grid-flow-col grid-rows-2 gap-4 py-1">

                                @foreach ($permissions as $permission)
                                    <x-input.checkbox wire:model.defer='selectedPermissions'
                                        id="{{ $permission->id }}" fieldKey="{{ $permission->key }}" />
                                @endforeach

                            </div>

                        </x-input.group>

                        <div class="flex justify-end gap-4 pt-4">

                            <x-jet-button wire:click='saveUser' class="p-2 w-28">
                                <span class="mx-auto">
                                    {{ __('fields.save') }}
                                </span>
                            </x-jet-button>

                            <x-jet-secondary-button wire:click='resetUser' class="p-2 w-28">
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
    <x-modals.confirmation action='deleteUser' model='showDelete' title="{{ __('fields.delete-user') }}" />

    <x-modals.content action='saveUser' model='showEditModal' title="{{ __('fields.edit-user') }}">

        <x-input.group inline label="{{ __('fields.name') }}" for='user.name' :error="$errors->first('editing.name')">

            <x-jet-input wire:model.defer='editing.name' id="user.name" class="block w-full" type="text"
                name="editing.name" placeholder="{{ __('placeholders.enter-name') }}" :value="old('editing.name')" />

        </x-input.group>

        <x-input.group inline for="user.branch" label="{{ __('fields.branch') }}" :error="$errors->first('editing.branch_id')">

            <x-input.select id="user.branch" placeholder="{{ __('fields.select-branch') }}"
                wire:model.defer="editing.branch_id">
                @foreach ($branches as $key => $branch)
                    <option value="{{ $branch->id }}">
                        {{ $branch->name }}
                    </option>
                @endforeach
            </x-input.select>

        </x-input.group>

        <x-input.group inline label="{{ __('fields.username') }}" for='user.username' :error="$errors->first('editing.username')">

            <x-jet-input wire:model.defer='editing.username' id="user.username" class="block w-full" type="text"
                name="editing.username" placeholder="{{ __('placeholders.enter-username') }}" :value="old('editing.username')" />

        </x-input.group>

        <x-input.group inline label="{{ $showEdit ? __('fields.change-password') : __('fields.password') }}"
            for='user.password' :error="$errors->first('editing.beforeHashPassword')">

            <x-jet-input wire:model.defer='editing.beforeHashPassword' id="user.password" class="block w-full"
                type="text" name="editing.password" placeholder="{{ __('placeholders.enter-password') }}"
                :value="old('editing.beforeHashPassword')" />

        </x-input.group>

        <x-input.group inline label="{{ __('fields.permissions') }}" for='' :error="$errors->first('selectedPermissions')">

            <div class="grid grid-flow-col grid-rows-4 gap-4 py-1">

                @foreach ($permissions as $permission)
                    <x-input.checkbox wire:model.defer='selectedPermissions' id="{{ $permission->id }}"
                        fieldKey="{{ $permission->key }}" />
                @endforeach

            </div>

        </x-input.group>

    </x-modals.content>

</div>