@props(['id', 'name', 'url', 'costPrice', 'addAction'])

<article

    wire:click='{{ "{$addAction}({$id})" }}'
    x-init
    x-data="{category_tibs:document.querySelectorAll('.category-tip')}"
    x-on:click='(x)=>{category_tibs.forEach((el)=>{el.classList.remove("ring-m-orange" ,"bg-opacity-40" ,"scale-105" ,"ring" , "ring-m-orange")}) ;
    x.target.closest("article").classList.add("ring-m-orange" ,"bg-opacity-40" ,"scale-105" ,"ring" , "ring-m-orange")}'
    class="category-tip rounded-lg shadow-lg p-4 2xl:p-4 lg:p-2 bg-[#6E7180] bg-opacity-20 gap-4 2xl:gap-4 lg:gap-2 cursor-pointer hover:bg-opacity-40 hover:scale-105 hover:ring  items-center flex flex-row w-40 2xl:w-44 lg:w-40 h-16 justify-center border border-m-orange/20 transition delay-100 " >

    <!-- Avatar -->
    <img class="w-10 h-10 border rounded-full border-m-blue/30 2xl:h-10 2xl:w-10" src="{{ $url }}"
        alt="{{ \Illuminate\Support\Str::kebab($name) . '-photo' }}">

    <!-- Title / Subtitle / Sub-subtitle-->
    <div class="flex flex-col items-center justify-center gap-1">
        <span class="text-sm font-roboto-m">{{ \Illuminate\Support\Str::limit($name, 11, '..') }}</span>
    </div>

</article>
