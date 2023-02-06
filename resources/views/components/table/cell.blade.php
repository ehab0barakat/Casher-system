@props(['wrap' => false])
<td
    {{ $attributes->merge(['class' => 'px-6 py-4 leading-5 font-roboto text-cool-gray-900 ' . (!$wrap ? 'whitespace-no-wrap' : '')]) }}>
    {{ $slot }}
</td>
