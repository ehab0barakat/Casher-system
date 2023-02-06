@props(['label', 'for', 'error' => false, 'helpText' => false, 'inline' => false, 'paddingless' => false, 'borderless' => false])

@if ($inline)
    <div>
        <label for="{{ $for }}"
            class="block text-sm leading-5 text-m-orange-l font-roboto-m">{{ $label }}</label>

        <div class="relative mt-3 rounded-md shadow-sm">
            {{ $slot }}

            @if ($error)
                <div class="mt-1 text-sm text-red-500">{{ $error }}</div>
            @endif

            @if ($helpText)
                <p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>
            @endif
        </div>
    </div>
@else
    <div
        class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start {{ $borderless ? '' : ' sm:border-t ' }} sm:border-gray-200 {{ $paddingless ? '' : ' sm:py-5 ' }}">
        <label for="{{ $for }}" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
            {{ $label }}
        </label>

        <div class="mt-1 sm:mt-0 sm:col-span-2">
            {{ $slot }}

            @if ($error)
                <div class="mt-1 text-sm text-red-500">{{ $error }}</div>
            @endif

            @if ($helpText)
                <p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>
            @endif
        </div>
    </div>
@endif
