@props(['disable' => false])
<button
    {{ $attributes->merge(['class' =>'inline-flex rounded-full items-center p-2 bg-m-blue border border-transparent rounded-md font-roboto-b text-xs text-white uppercase tracking-widest hover:bg-m-blue-d active:bg-m-blue-d focus:outline-none focus:border-m-orange disabled:opacity-25 transition '
    . ($disable ? 'opacity-30' : 'ring ring-m-orange')]) }}>
    {{ $slot }}
</button>
