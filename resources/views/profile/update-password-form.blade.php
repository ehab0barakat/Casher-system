<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('fields.update-password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('fields.profile-passwords-description') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="current_password" value="{{ __('fields.current-password') }}" />
            <x-jet-input id="current_password" type="password" class="block w-full mt-1"
                wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password" value="{{ __('fields.new-password') }}" />
            <x-jet-input id="password" type="password" class="block w-full mt-1" wire:model.defer="state.password"
                autocomplete="new-password" />
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password_confirmation" value="{{ __('fields.confirm-password') }}" />
            <x-jet-input id="password_confirmation" type="password" class="block w-full mt-1"
                wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <x-jet-input-error for="password_confirmation" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('fields.save-msg') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('fields.save') }}
        </x-jet-button>

    </x-slot>

</x-jet-form-section>
