<div>
    <div>
        <div class="flex items-center justify-between">
            <span class="block text-sm leading-5 text-m-orange-l font-roboto-m">{{ __('fields.categories') }}</span>

            <!-- Service Search Input -->
            <div class="w-1/4">
                <x-jet-input id="category.search" wire:model.debounce.400ms='searchCategory'
                    class="w-full disabled:opacity-30" type="text" name="category.search"
                    placeholder="{{ __('placeholders.search-categories') }}" :value="old('searchCategory')"/>
            </div>

        </div>

        <div class="relative mt-3 rounded-md shadow-sm">

            <div wire:loading.class.delay='opacity-50'
                class="grid gap-2  grid-rows-4 grid-flow-col pb-2 pt-1 overflow-x-auto transition delay-100 2xl:gap-2 lg:gap-2">

                @forelse ($categories as $key => $category)
                    <div class="" wire:key='l-s-{{ $key }}'>
                        <x-cards.category-simple id="{{ $category->id }}" name="{{ $category->name }}"
                            url="{{ $category->getPhotoOrDefaultUrl()}}" costPrice="{{ $category->description }}"
                            addAction='showAddCategory' />
                    </div>
                @empty

                    <div class="flex items-center justify-center flex-grow">

                        <span class="text-m-blue">
                            <x-icons.info size="24" />
                        </span>

                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
