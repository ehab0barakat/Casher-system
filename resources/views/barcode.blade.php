<x-guest-layout>

    {{-- Large Paper Size --}}
    {{-- <div class="flex flex-col items-center justify-center flex-grow gap-2" style="width: 200px; height: 100px">

        <!-- Logo -->
        <div class="mt-10">
            <img class="h-10" src="{{ asset('img/logo.png') }}" alt="icon-logo-alt">
        </div>

        <div class="flex items-center justify-center gap-4">

            <!-- QR -->
            <div>
                {!! DNS2D::getBarcodeHTML($product->barcodeId, 'QRCODE', 3, 3) !!}
            </div>

            <div class="flex flex-col">
                <!-- Product Name-->
                <span class="font-roboto-m">
                    {{ $product->name }}
                </span>

                <!-- Product Retail Price-->
                <span class="font-roboto-m">
                    {{ $product->retailPriceInCurrency }}
                </span>

            </div>

        </div>

    </div> --}}

    {{-- Small Paper Size --}}
    <div class="flex flex-col items-center justify-center">

        <div style="width: 145px;  height: 40px;">

            <div class="flex items-center justify-center gap-1 mt-[8px]">

                <!-- Logo -->
                <img class="h-3 " src="{{ asset('img/logo.png') }}" alt="icon-logo-alt">

                <div class="flex flex-col">

                    <!-- Product Name-->
                    <span class="font-roboto-m" style="font-size: 0.4rem; line-height: 0.7rem;">
                        {{ \Illuminate\Support\Str::limit($product->name, 10, '..') }}
                    </span>

                    <!-- Product Retail Price-->
                    <span class="font-roboto-m" style="font-size: 0.4rem; line-height: 0.7rem;">
                        {{ $product->retailPrice }}
                    </span>

                </div>

                <!-- 2D Code -->
                <div>
                    {!! DNS2D::getBarcodeHTML($product->barcodeId, 'DATAMATRIX', 2, 2) !!}
                </div>

            </div>

        </div>

        <div style="width: 145px;">

            <div class="flex items-center justify-center gap-1 mt-[15px]">

                <!-- Logo -->
                <img class="h-3 " src="{{ asset('img/logo.png') }}" alt="icon-logo-alt">

                <!-- 2D Code -->
                <div>
                    {!! DNS2D::getBarcodeHTML($product->barcodeId, 'DATAMATRIX', 2, 2) !!}
                </div>

                <div class="flex flex-col">

                    <!-- Product Name-->
                    <span class="font-roboto-m" style="font-size: 0.4rem; line-height: 0.7rem;">
                        {{ \Illuminate\Support\Str::limit($product->name, 10, '..') }}
                    </span>

                    <!-- Product Retail Price-->
                    <span class="font-roboto-m" style="font-size: 0.4rem; line-height: 0.7rem;">
                        {{ $product->retailPrice }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>
