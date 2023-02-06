<button
    {{ $attributes->merge(['type' => 'submit','class' =>'inline-flex items-center px-4 py-2 bg-m-orange border border-transparent rounded-md font-roboto-b text-xs text-white uppercase tracking-widest hover:bg-m-orange-d active:bg-m-orange-d focus:outline-none focus:border-m-blue focus:ring focus:ring-m-blue disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
