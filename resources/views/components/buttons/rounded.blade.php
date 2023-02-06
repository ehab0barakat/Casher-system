@props(['color' => 'm-orange', 'hover' => 'm-orange-d' , "applyScanner"])

@php
     if (isset($applyScanner) ){
        if(!$applyScanner){
            $color = "gray-400";
            $hover = "gray-500" ;
        };
     };
@endphp

<button
    {{ $attributes->merge(['class' =>'inline-flex rounded-full disabled:opacity-30 items-center p-2 bg-'.$color .' border border-transparent rounded-md font-roboto-b text-xs text-white uppercase tracking-widest hover:bg-' .$hover .' active:bg-' .$hover .' focus:outline-none focus:border-m-blue focus:ring focus:ring-m-blue disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
