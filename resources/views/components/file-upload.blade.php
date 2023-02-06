@props(['error' => false])
<div class="flex flex-col items-center justify-center gap-4">

    {{ $slot }}

    <div x-data="{ focused: false }">
        <span class="mx-5 rounded-md shadow-sm lg:mx-2 2xl:mx-5">
            <input @focus="focused = true" @blur="focused = false" class="sr-only" type="file"
                {{ $attributes }}>
            <label for="{{ $attributes['id'] }}" :class="{ 'outline-none border-m-blue ring ring-m-blue': focused }"
                class="inline-flex items-center p-2 text-xs text-white uppercase transition border border-transparent rounded-full cursor-pointer bg-m-orange font-roboto-l hover:bg-m-orange-d active:bg-m-orange-d disabled:opacity-25">
                {{ __('fields.choose-image') }}
            </label>
        </span>
    </div>

    @if ($error)
        <div class="mt-1 text-sm text-red-500">{{ $error }}</div>
    @endif
</div>
