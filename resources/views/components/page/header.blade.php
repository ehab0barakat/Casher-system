<div class="bg-white border-b shadow lg:hidden border-m-orange">
    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">

        <div class="flex flex-col gap-4">

            <!-- Header & Actions -->
            <div class="flex items-center justify-between">

                <!-- Header -->
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ $header }}
                </h2>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    {{ $actions }}
                </div>

            </div>

            @isset($secondaryActions)
                <div x-data class="flex items-center justify-center gap-4">
                    {{ $secondaryActions }}
                </div>
            @endisset

        </div>

    </div>
</div>
