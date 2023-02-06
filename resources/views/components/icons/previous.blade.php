@props(["action"])

<button  wire:click="{{"{$action}()" }}" class="bg-m-orange-l w-10 h-10  rounded-full 2xl:w-12 2xl:h-12 round text-white ">

    <img src="{{asset('img/icons/back-icon.png')}}" alt="">

</button>
