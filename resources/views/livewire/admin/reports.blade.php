                <!-- Summary Table -->
                <div class="w-full overflow-y-auto shadow-md rounded-xl border-m-orange-l/20 shadow-m-orange-l/50 ">




                    <div x-init x-data="$refs.datepick.daterangepicker({opens: 'center'}, function(start, end, label) { console.log(start)})">

                        <input type="text" x-init x-ref="datepick"   wire:model="date" name="daterange" value="01/01/2018 - 01/15/2018" />

                    </div>




                    <x-table>

                        <x-slot name="head">

                            <x-table.heading>#</x-table.heading>

                            <x-table.heading>{{ __('fields.casher') }}</x-table.heading>

                            <x-table.heading>{{ __('fields.branch') }}</x-table.heading>

                            <x-table.heading>{{ __('fields.client') }}</x-table.heading>

                            <x-table.heading>{{ __('fields.products') }}</x-table.heading>

                            <x-table.heading>{{ __('fields.total') }}</x-table.heading>

                            <x-table.heading>{{ __('fields.receipt') }}</x-table.heading>

                        </x-slot>

                        <x-slot name="body">
                            @forelse ($itemsList as $item)
                                <x-table.row wire:key='t-r-{{ $loop->index }}' wire:loading.class.delay="opacity-50"
                                    class="transition delay-100">

                                    <x-table.cell>{{ ++$loop->index }}</x-table.cell>

                                    <x-table.cell>{{$item->user->name }}</x-table.cell>

                                    <x-table.cell>{{ $item->branch->name }}</x-table.cell>

                                    <x-table.cell>{{ $item->client->name }}</x-table.cell>




                                    <x-table.cell>
                                        <table class="table-auto">

                                            <thead>

                                                <tr>

                                                    <th>Product name</th>

                                                    <th>Quantity</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                @foreach ( $item->products as $product )
                                                <tr>

                                                    <td class="text-start">{{$item->product_name($product->product_id)}}</td>

                                                    <td class="text-center">{{$product->quantity}}</td>
                                                </tr>

                                                @endforeach

                                            </tbody>

                                        </table>

                                    </x-table.cell>


                                    <x-table.cell>{{$item->total}}</x-table.cell>


                                    <x-table.cell class="flex justify-center ">
                                        <a href="{{ url("/receipts")."/".$loop->iteration}}" target="_blank"  >

                                            <button>
                                                <img class="w-10 h-10 shadow-xl 2xl:w-10 2xl:h-10 lg:w-20 lg:h-20 "
                                                src="{{ asset('img/icons/qr.svg')}}" alt="qr-scanner-gif">
                                            </button>

                                        </a>
                                    </x-table.cell>


                                </x-table.row>
                            @empty
                                <x-table.row wire:loading.class.delay="opacity-50" class="transition delay-100">

                                    <x-table.cell colspan="6">

                                        <div class="flex items-center justify-center flex-grow">

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


{{--
<script>
$(function() {
    $('input[name="daterange"]').daterangepicker({
    opens: 'center'
    }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
});
</script> --}}
