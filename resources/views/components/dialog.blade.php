@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>

    <!-- Title -->
    <div class="px-6 py-4 rounded-md shadow-md bg-m-blue-l shadow-m-orange-l/50">
        <div class="text-lg text-white font-roboto-m">
            {{ $title }}
        </div>
    </div>

    <div class="px-6 py-4 mt-4 font-roboto">
        {{ $content }}
    </div>

    <div class="flex justify-end gap-4 px-6 py-4 bg-[#6E7180] bg-opacity-20">
        {{ $footer }}
    </div>

</x-modal>
