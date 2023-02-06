<button
    {{ $attributes->merge(['type','button','class' =>'inline-flex items-center px-4 py-2 bg-white border border-m-orange-l rounded-md font-roboto-l text-xs text-m-orange uppercase tracking-widest hover:bg-gray-100 active:bg-gray-200  focus:outline-none focus:border-m-blue focus:ring focus:ring-m-blue disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
