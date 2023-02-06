@props(['id', 'fieldKey'])
<label for="{{ $id }}" class="flex items-center">
    <x-jet-checkbox id="{{ $id }}" name="{{ $id }}" value="{{ $id }}" {{ $attributes }}/>
    <span class="mx-2 text-sm text-gray-600 font-roboto">{{ __('fields.' . $fieldKey) }}</span>
</label>
