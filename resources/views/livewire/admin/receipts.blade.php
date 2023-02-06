<div>

    <style>
        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 2px;
        }

    </style>

    <div class="flex flex-col gap-1" style="width: 303px;">

        <!-- Logo / QR -->
        <div class="flex items-center justify-between px-4">

            <span>
                <img class="h-6" src="{{ asset('img/logo.png') }}">
            </span>

            <span>
                {!! DNS2D::getBarcodeHTML('https://www.facebook.com/icontechnologys', 'QRCODE', 2, 2) !!}
            </span>

        </div>

        <hr class="my-1 h-[0.2px] bg-m-orange">

        <!-- User -->
        <div class="flex flex-col gap-1">

            <span class="text-sm font-roboto-l">Order:
                <span class="text-sm font-roboto-m">{{ '#' . $order->id }}</span>
            </span>

            <span class="text-sm font-roboto-l">Date:
                <span class="text-sm font-roboto-m">{{ \Carbon\Carbon::now()->format('d/m/Y - H:i:s') }}</span>
            </span>

            <span class="text-sm font-roboto-l">Cashier:
                {{-- <span class="text-sm font-roboto-m">{{ $order->user->name }}</span> --}}
            </span>

            <span class="text-sm font-roboto-l">Branch:
                <span class="text-sm font-roboto-m">{{ $order->user->branch->name }}</span>
            </span>

        </div>

        <!-- Items List -->
        <div class="my-2">
            <table class="w-full">
                <thead>
                    <tr>
                        <td class="text-xs font-roboto-l">Item #</td>
                        <td class="text-xs font-roboto-l">Name</td>
                        <td class="text-xs font-roboto-l">Price</td>
                        <td class="text-xs font-roboto-l">Q.</td>
                        <td class="text-xs font-roboto-l">Subtotal</td>
                    </tr>
                </thead>

                <tbody>


                    <!-- Products -->
                    @foreach ($products as $item)
                        <tr>
                            <td class="text-xs font-roboto-l">
                                {{ ++$loop->index }}
                            </td>
                            <td class="text-xs font-roboto-l">
                                {{ \Illuminate\Support\Str::limit($item->product->name, 18, '..') }}
                            </td>
                            <td class="text-xs font-roboto-l">
                                {{ $item->product->retailPrice }}
                            </td>
                            <td class="text-xs font-roboto-l">
                                {{ $item->quantityInTwoDigits }}
                            </td>
                            <td class="text-xs font-roboto-M">
                                {{ $item->quantity * $item->product->retailPrice }}
                            </td>
                        </tr>
                    @endforeach

                    <!-- SUBTOTAL -->
                    <tr>
                        <td class="p-1 text-xs text-center font-roboto-m" colspan="2">
                            Summary
                        </td>

                        <td class="p-1 text-xs text-center font-roboto-m" colspan="3">
                            {{ $order->subtotalInCurrency . ' EGP' }}
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        <!-- SUMMARY -->
        <div class="flex flex-col gap-1">

            <span class="text-sm font-roboto-l">Discount:
                <span class="text-sm font-roboto-m">{{ $order->discountInCurrency . ' EGP' }}</span>
            </span>

            <span class="text-sm font-roboto-l">Total:
                <span class="text-sm font-roboto-m">{{ $order->totalInCurrency . ' EGP' }}</span>
            </span>

        </div>


    </div>


</div>
