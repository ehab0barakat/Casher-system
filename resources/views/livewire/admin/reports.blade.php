<div>

    <!-- Summary Table -->
    <input type="text" id="daterange"  />

    <div class="w-full overflow-y-auto shadow-md rounded-xl border-m-orange-l/20 shadow-m-orange-l/50 flex ">
        <x-table style="width:80%" >

            <x-slot name="head">

                <x-table.heading>#</x-table.heading>

                <x-table.heading  >{{ __('fields.casher') }}</x-table.heading>

                {{--  <x-table.heading>{{ __('fields.branch') }}</x-table.heading>  --}}

                <x-table.heading  >{{ __('fields.client') }}</x-table.heading>

                <x-table.heading class="flex justify-center" >{{ __('fields.products') }}</x-table.heading>

                <x-table.heading>{{ __('fields.subtotal') }}</x-table.heading>

                <x-table.heading>{{ __('fields.discount') }}</x-table.heading>

                <x-table.heading>{{ __('fields.total') }}</x-table.heading>

                <x-table.heading>{{ __('fields.profit') }}</x-table.heading>

                <x-table.heading>{{ __('fields.receipt') }}</x-table.heading>

            </x-slot>

            <x-slot name="body" >
                @forelse ($itemsList as $item)

                    <x-table.row  wire:key='t-r-{{ $loop->index }}' wire:loading.class.delay="opacity-50"
                        class=" transition delay-100 {{$loop->index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100'  }} "
                            style="background-color: {{$item->order_type  == '1' ? 'rgb(254 226 226)' : '' }} "
                        >

                        <x-table.cell class="text-center">{{ ++$loop->index }}</x-table.cell>

                        <x-table.cell class="text-center">{{ $item->user->name }}</x-table.cell>

                        {{--  <x-table.cell>{{ $item->branch->name }}</x-table.cell>  --}}


                        @if ($item->client)
                            <x-table.cell>{{ $item->client->name }}</x-table.cell>
                        @else
                            <x-table.cell>No Name</x-table.cell>
                        @endif

                        <x-table.cell class="bg-red flex justify-center" >

                            <table class="w-full">

                                    <thead>
                                        <tr class="flex justify-between">
                                            <th class="text-center p-1">Product name</th>
                                            <th class="text-center p-1">Quantity</th>
                                            <th class="text-center p-1">Price</th>
                                            <th class="text-center p-1">Subtotal</th>
                                        </tr>

                                    </thead>

                                <tbody >

                                    @foreach ($item->products as $product)
                                        <tr class="flex justify-between	">
                                            <td class="text-center p-1 w-min">{{ $product->name }}</td>
                                            <td class="text-center p-1 ">{{ $product->quantity }}</td>
                                            <td class="text-center p-1">{{ $product->costPrice }}</td>
                                            <td class="text-center p-1">{{ $product->costTotal}}</td>
                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </x-table.cell>

                        <x-table.cell class="text-center">{{ $item->subtotal }}</x-table.cell>

                        <x-table.cell class="text-center">{{ $item->discount }}</x-table.cell>

                        <x-table.cell class="text-center">{{ $item->total }}</x-table.cell>

                        <x-table.cell class="text-center">{{ $item->total - $item->products()->sum('retailTotal') -  $item->discount }}</x-table.cell>


                        <x-table.cell class="text-center">
                            <a href="{{ url('/receipts') . '/' . $loop->iteration }}" target="_blank">
                                <button>
                                    <img class="w-5 h-5 shadow-xl 2xl:w-5 2xl:h-5 lg:w-10 lg:h-10 "
                                        src="{{ asset('img/icons/qr.svg') }}" alt="qr-scanner-gif">
                                </button>
                            </a>
                        </x-table.cell>


                    </x-table.row>
                @empty
                    <x-table.row wire:loading.class.delay="opacity-50" class="transition delay-100">

                        <x-table.cell colspan="6">

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
        body{
            overflow-y: scroll !important;
        }
    </style>

</div>
