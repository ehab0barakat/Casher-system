<div>

    <style>
        td,
        th {
            border: 1px solid black;
            font-bold text-black text-align: left;
            padding: 2px;
        }
    </style>

    <div class=" flex flex-col gap-1" style="width: 303px;">

        <!-- Logo / QR -->
        <div class=" flex items-center justify-between px-4">

            <span>
                <img class=" h-6" src="{{ asset('img/logo.png') }}">
            </span>

            <span>
                {!! DNS2D::getBarcodeHTML('https://www.facebook.com/icontechnologys', 'QRCODE', 2, 2) !!}
            </span>

        </div>

        <hr class=" my-1 h-[0.2px] bg-m-orange">

        <!-- User -->
        <div class=" flex flex-col gap-1">

            <span class="font-bold text-black	text-lg ">Order:
                <span class="font-bold text-black	text-lg ">{{ '#' . $order->id }}</span>
            </span>

            <span class="font-bold text-black	text-lg ">Date:
                <span class="font-bold text-black	text-lg ">{{ \Carbon\Carbon::now()->format('d/m/Y - H:i:s') }}</span>
            </span>

            <span class="font-bold text-black	text-lg ">Cashier:
                <span class="font-bold text-black	text-lg ">{{ $order->user->name }}</span>
            </span>

            <span class="font-bold text-black	text-lg ">Branch:
                <span class="font-bold text-black	text-lg ">{{ $order->user->branch->name }}</span>
            </span>

            @if ($order->client)
                <span class="font-bold text-black	text-lg ">Customer Name:
                    <span class="font-bold text-black	text-lg ">{{ $order->client->name }}</span>
                </span>
            @endif

        </div>

        <!-- Items List -->
        <div class=" my-2">
            <table class=" w-full">
                <thead>
                    <tr>
                        <td class="font-bold text-black	text-sm ">Item #</td>
                        <td class="font-bold text-black	text-sm ">Name</td>
                        <td class="font-bold text-black	text-sm ">Price</td>
                        <td class="font-bold text-black	text-sm ">Q.</td>
                        <td class="font-bold text-black	text-sm ">Subtotal</td>
                    </tr>
                </thead>

                <tbody>


                    <!-- Products -->
                    @foreach ($products as $item)
                        <tr>
                            <td class="font-bold text-black	text-sm ">
                                {{ ++$loop->index }}
                            </td>
                            <td class="font-bold text-black	text-sm ">
                                {{ \Illuminate\Support\Str::limit($item->product->name, 18, '..') }}
                            </td>
                            <td class="font-bold text-black	text-sm ">
                                {{ $item->costPrice }}
                            </td>
                            <td class="font-bold text-black	text-sm ">
                                {{ $item->quantityInTwoDigits }}
                            </td>
                            <td class="font-bold text-black	text-sm ">
                                {{ $item->quantity * $item->costPrice }}
                            </td>
                        </tr>
                    @endforeach

                    <!-- SUBTOTAL -->
                    <tr>
                        <td class=" p-1font-bold text-black	text-sm font-bold text-black	text-center " colspan="2">
                            Summary
                        </td>

                        <td class=" p-1font-bold text-black	text-sm font-bold text-black	text-center " colspan="3">
                            {{ $order->subtotalInCurrency . ' EGP' }}
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        <!-- SUMMARY -->
        <div class=" flex flex-col gap-1 ">

            <span class="font-bold text-black	text-lg ">Discount:
                <span class="font-bold text-black	text-lg ">{{ $order->discountInCurrency . ' EGP' }}</span>
            </span>

            <span class="font-bold text-black text-lg ">Total:
                <span class="font-bold text-black text-lg ">{{ $order->totalInCurrency . ' EGP' }}</span>
            </span>

            <span class="h-64 flex items-end text-white">`</span>

        </div>
    </div>
</div>
