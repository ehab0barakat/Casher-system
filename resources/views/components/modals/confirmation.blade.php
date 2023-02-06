@props(['action', 'model', 'title'])


<x-dialog wire:model.defer='{{ $model }}'>

    <x-slot name="title">{{ $title }}</x-slot>

    <x-slot name="content">

        <span>
            {{ __('fields.confirmation') }}
        </span>

    </x-slot>

    <x-slot name="footer">

        <x-jet-secondary-button wire:click="$set('{{ $model }}', false)">
            {{ __('fields.cancel') }}
        </x-jet-secondary-button>

        <form wire:submit.prevent='{{ $action }}'>
            <x-jet-button type="submit">
                {{ __('fields.confirm') }}
            </x-jet-button>
        </form>

    </x-slot>

</x-dialog>
