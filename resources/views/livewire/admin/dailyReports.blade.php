<div>

    <!-- Summary Table -->
    <input type="text" id="daterange" />

    <div class="w-full overflow-y-auto shadow-md rounded-xl border-m-orange-l/20 shadow-m-orange-l/50 flex ">
        <x-table style="width:80%">




            <x-slot name="head">

                <x-table.heading>#</x-table.heading>

                <x-table.heading> {{ __('fields.day') }}</x-table.heading>

                <x-table.heading> {{ __('fields.total') }}</x-table.heading>

                <x-table.heading> {{ __('fields.capital') }}</x-table.heading>

                <x-table.heading> {{ __('fields.capital_gross') }}</x-table.heading>

                <x-table.heading> {{ __('fields.profit') }}</x-table.heading>

            </x-slot>

            <x-slot name="body">
                @forelse ($itemsList as $item)
                    <x-table.row wire:key='t-r-{{ $loop->index }}' wire:loading.class.delay="opacity-50"
                        class=" transition delay-100 {{ $loop->index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100' }} ">

                        <x-table.cell>{{ ++$loop->index }}</x-table.cell>

                        <x-table.cell>{{ $item->day }}</x-table.cell>

                        <x-table.cell>{{ $item->total }}</x-table.cell>

                        <x-table.cell>{{ $item->capital }}</x-table.cell>

                        <x-table.cell>{{ $item->capital_gross }}</x-table.cell>

                        <x-table.cell>{{ $item->profit }}</x-table.cell>

                    </x-table.row>
                @empty
                    <x-table.row wire:loading.class.delay="opacity-50" class="transition delay-100">

                        <x-table.cell colspan="9">

                            <div class="flex items-center justify-center  flex-grow">

                                <span>
                                    <img class="w-24 h-24 border-2 rounded-full shadow-xl 2xl:w-24 2xl:h-24 lg:w-20 lg:h-20 border-m-blue"
                                        src="{{ asset('img/qr-scan.gif') }}" alt="qr-scanner-gif">
                                </span>

                            </div>

                        </x-table.cell>

                    </x-table.row>
                @endforelse

            </x-slot>

        </x-table>


    </div>


    {{-- Pagination --}}
    <div class="flex justify-evenly	mt-5 gap-1">
        {!! $itemsList->links() !!}
    </div>

    <script>
        $(function() {
            $('#daterange').daterangepicker({
                opens: 'center',
            }, function(start, end, label) {
                Livewire.emit('dateChange', start, end);
            });
        });
    </script>

    <style>
        body {
            overflow-y: scroll !important;
        }
    </style>

</div>
