<x-modals.content action='saveClient' model='showEditModal' title="{{ __('fields.edit-client') }}">

    <x-input.group inline label="{{ __('fields.name') }}" for='client.name' :error="$errors->first('editing.name')">

        <x-jet-input wire:model.defer='editing.name' id="client.name" class="block w-full" type="text"
            name="editing.name" placeholder="{{ __('placeholders.enter-name') }}" :value="old('editing.name')" />

    </x-input.group>

    <x-input.group inline label="{{ __('fields.phone') }}" for='client.phone' :error="$errors->first('editing.phone')">

        <x-jet-input wire:model.defer='editing.phone' id="client.phone" class="block w-full" type="text"
            name="editing.phone" placeholder="{{ __('placeholders.enter-phone') }}" :value="old('editing.phone')" />

    </x-input.group>

</x-modals.content>
