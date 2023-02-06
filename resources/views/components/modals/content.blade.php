@props(['action', 'model', 'title'])

<x-dialog wire:model.defer='{{ $model }}'>

    <x-slot name="title">{{ $title }}</x-slot>

    <x-slot name="content">
        <div class="flex flex-col gap-4">
            {{ $slot }}
        </div>
    </x-slot>

    <x-slot name="footer">

        <x-jet-secondary-button wire:click="$set('{{ $model }}', false)">
            {{ __('fields.cancel') }}
        </x-jet-secondary-button>

        <form wire:submit.prevent='{{ $action }}'>
            <x-jet-button type="submit">
                {{ __('fields.save') }}
            </x-jet-button>
        </form>

    </x-slot>

</x-dialog>
