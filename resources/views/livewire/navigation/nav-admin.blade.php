<nav x-data="{ open: false }">

    <div @class([
        'border-l-8 ' => app()->getLocale() == 'en',
        'border-r-8 ' => app()->getLocale() == 'ar',
        'w-full p-2 text-white shadow-md border-m-orange shadow-m-orange-l bg-m-blue' => true,
    ])>
        <!-- Primary Navigation Menu -->
        <div class="flex items-center justify-between">

            <div class="flex mx-2 lg:mx-2 2xl:mx-6">

                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('home') }}">
                        <x-jet-application-mark class="block w-auto h-12 p-2 bg-white rounded-lg" />
                    </a>
                </div>

                <!-- USER INFO -->
                <div class="flex flex-col mx-4 lg:mx-6 2xl:mx-3">

                    <span class="text-lg text-opacity-75 2xl:text-lg lg:text-base font-roboto-m">
                        {{ \App\Util\Formatting::getNameForNavBar() }}
                    </span>

                    <span class="text-opacity-60 font-roboto-l">
                        {{ \App\Util\Formatting::getUserTypeForNavBar() }}
                    </span>

                </div>

            </div>

            <div class="flex items-center py-2 overflow-auto">

                <!-- Home Link -->
                <div class="hidden sm:-my-px lg:mx-1 2xl:mx-1 lg:flex">
                    <x-jet-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')"
                        src="{{ asset('img/icons/home.png') }}" alt="icon-alt" text="{{ __('fields.home') }}" />
                </div>

                <!-- Expenses Link -->
                @if (auth()->user()->has('p-expenses'))
                    <div class="hidden sm:-my-px lg:mx-1 2xl:mx-1 lg:flex">
                        <x-jet-nav-link href="{{ route('admin.expenses') }}" :active="request()->routeIs('admin.expenses')"
                            src="{{ asset('img/icons/expenses.png') }}" alt="icon-alt"
                            text="{{ __('fields.expenses') }}" />
                    </div>
                @endif

                <!-- SUPPLIERS Link -->
                @if (auth()->user()->has('p-suppliers'))
                    <div class="hidden sm:-my-px lg:mx-1 2xl:mx-1 lg:flex">
                        <x-jet-nav-link href="{{ route('admin.suppliers') }}" :active="request()->routeIs('admin.suppliers')"
                            src="{{ asset('img/icons/suppliers.png') }}" alt="icon-alt"
                            text="{{ __('fields.suppliers') }}" />
                    </div>
                @endif

                <!-- PRODUCTS Link -->
                @if (auth()->user()->has('p-products'))
                    <div class="hidden sm:-my-px lg:mx-1 2xl:mx-1 lg:flex">
                        <x-jet-nav-link href="{{ route('admin.products') }}" :active="request()->routeIs('admin.products')"
                            src="{{ asset('img/icons/products.png') }}" alt="icon-alt"
                            text="{{ __('fields.products') }}" />
                    </div>
                @endif

                <!-- CLIENTS Link -->
                @if (auth()->user()->has('p-clients'))
                    <div class="hidden sm:-my-px lg:mx-1 2xl:mx-1 lg:flex">
                        <x-jet-nav-link href="{{ route('admin.clients') }}" :active="request()->routeIs('admin.clients')"
                            src="{{ asset('img/icons/clients.png') }}" alt="icon-alt"
                            text="{{ __('fields.clients') }}" />
                    </div>
                @endif

                <!-- Branches Link -->
                @if (auth()->user()->has('p-branches'))
                    <div class="hidden sm:-my-px lg:mx-1 2xl:mx-1 lg:flex">
                        <x-jet-nav-link href="{{ route('admin.branches') }}" :active="request()->routeIs('admin.branches')"
                            src="{{ asset('img/icons/branches.png') }}" alt="icon-alt"
                            text="{{ __('fields.branches') }}" />
                    </div>
                @endif

                <!-- Categories Link -->
                @if (auth()->user()->has('p-categories'))
                    <div class="hidden sm:-my-px lg:mx-1 2xl:mx-1 lg:flex">
                        <x-jet-nav-link href="{{ route('admin.categories') }}" :active="request()->routeIs('admin.categories')"
                            src="{{ asset('img/icons/categories.png') }}" alt="icon-alt"
                            text="{{ __('fields.categories') }}" />
                    </div>
                @endif

                <!-- Workers Link -->
                @if (auth()->user()->has('p-workers'))
                    <div class="hidden sm:-my-px lg:mx-1 2xl:mx-1 lg:flex">
                        <x-jet-nav-link href="{{ route('admin.workers') }}" :active="request()->routeIs('admin.workers')"
                            src="{{ asset('img/icons/workers.png') }}" alt="icon-alt"
                            text="{{ __('fields.workers') }}" />
                    </div>
                @endif

                <!-- Users Link -->
                @if (auth()->user()->has('p-users'))
                    <div class="hidden sm:-my-px lg:mx-1 2xl:mx-1 lg:flex">
                        <x-jet-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')"
                            src="{{ asset('img/icons/users.png') }}" alt="icon-alt" text="{{ __('fields.users') }}" />
                    </div>
                @endif


                <!-- Reports Link -->
                @if (auth()->user()->has('p-reports'))
                    <div class="hidden sm:-my-px lg:mx-1 2xl:mx-1 lg:flex">
                        <x-jet-nav-link href="{{ route('admin.reports') }}" :active="request()->routeIs('admin.reports')"
                            src="{{ asset('img/icons/qr.svg') }}" alt="icon-alt" text="{{ __('fields.reports') }}" />
                    </div>
                @endif

            </div>

            <!-- Notifications / Drop Down -->
            <div class="hidden lg:flex lg:items-center lg:mx-1 2xl:mx-1">

                <!-- Notification -->
                <div class="relative mx-3 lg:mx-1">
                    <x-jet-dropdown align="{{ app()->getLocale() == 'en' ? 'right' : 'left' }}" width="48">

                        <x-slot name="trigger">
                            <span class="inline-flex p-1 rounded-full bg-m-blue-d">
                                <button type="button"
                                    class="inline-flex items-center gap-2 p-2 leading-4 text-white transition bg-white border border-transparent rounded-md font-roboto-m hover:text-m-orange focus:outline-none">

                                    <span @class([
                                        'notify-wiggle text-m-orange' => count($notifications) > 0,
                                    ])>
                                        <x-icons.notification />
                                    </span>

                                    <style>
                                        .notify-wiggle {
                                            transform: translate(-50%, -50%);
                                            transform: rotate(0);
                                            transform-origin: 80% 30%;
                                            animation: wiggle .2s infinite;
                                        }

                                        @keyframes wiggle {
                                            0% {
                                                transform: rotate(6deg);
                                            }

                                            50% {
                                                transform: rotate(0deg);
                                            }

                                            100% {
                                                transform: rotate(6deg);
                                            }
                                        }
                                    </style>

                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">

                            @forelse ($notifications as $item)
                                <a href="{{ route('admin.products', ['item' => $item]) }}">
                                    <span
                                        class='block px-4 py-2 text-sm leading-5 text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:bg-gray-100'>
                                        {{ __('fields.notify-product', ['productName' => $item->name]) }}
                                    </span>
                                </a>
                            @empty
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('fields.no-notifications') }}
                                </div>
                            @endforelse

                        </x-slot>

                    </x-jet-dropdown>
                </div>

                <div class="relative mx-3">
                    <x-jet-dropdown align="{{ app()->getLocale() == 'en' ? 'right' : 'left' }}" width="48">
                        <x-slot name="trigger">
                            <span class="inline-flex p-1 rounded-lg bg-m-blue-d">
                                <button type="button"
                                    class="inline-flex items-center gap-2 px-3 py-2 leading-4 text-white transition bg-white border border-transparent rounded-md font-roboto-m hover:text-m-orange focus:outline-none">

                                    <span>
                                        {{ auth()->user()->username }}
                                    </span>

                                    <svg class="w-4 h-4 text-m-orange-l" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>

                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('fields.manage-account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('change-locale') }}">
                                {{ __('fields.change-language') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('fields.profile') }}
                            </x-jet-dropdown-link>

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('fields.logout') }}
                                </x-jet-dropdown-link>

                            </form>

                        </x-slot>

                    </x-jet-dropdown>
                </div>

            </div>

            <!-- Notifications (SM) -->
            <div class="flex items-center mx-1 lg:hidden">

                <div class="relative mx-3">
                    <x-jet-dropdown align="{{ app()->getLocale() == 'en' ? 'right' : 'left' }}" width="48">

                        <x-slot name="trigger">
                            <span class="inline-flex p-1 rounded-full bg-m-blue-d">
                                <button type="button"
                                    class="inline-flex items-center gap-2 p-2 leading-4 text-white transition bg-white border border-transparent rounded-md font-roboto-m hover:text-m-orange focus:outline-none">

                                    <span @class([
                                        'notify-wiggle text-m-orange' => count($notifications) > 0,
                                    ])>
                                        <x-icons.notification />
                                    </span>

                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">

                            @forelse ($notifications as $item)
                                <span
                                    class='block px-4 py-2 text-sm leading-5 text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:bg-gray-100'>
                                    <x-jet-responsive-nav-link href="{{ route('admin.products') }}">
                                        {{ __('fields.notify-product', ['productName' => $item->name]) }}
                                    </x-jet-responsive-nav-link>
                                </span>
                            @empty
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('fields.no-notifications') }}
                                </div>
                            @endforelse

                        </x-slot>

                    </x-jet-dropdown>
                </div>

            </div>

            <!-- Hamburger -->
            <div class="flex items-center mx-2 lg:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 text-white transition rounded-md bg-m-blue-d hover:text-black hover:bg-m-orange focus:outline-none focus:bg-m-orange-l focus:text-black">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>

    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden lg:hidden bg-m-blue-l">
        <div class="pt-2 pb-3 space-y-1">

            <!-- Home Link -->
            <x-jet-responsive-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                {{ __('fields.home') }}
            </x-jet-responsive-nav-link>

            <!-- Expenses Link -->
            @if (auth()->user()->has('p-expenses'))
                <x-jet-responsive-nav-link href="{{ route('admin.expenses') }}" :active="request()->routeIs('admin.expenses')">
                    {{ __('fields.expenses') }}
                </x-jet-responsive-nav-link>
            @endif

            <!-- Suppliers Link -->
            @if (auth()->user()->has('p-suppliers'))
                <x-jet-responsive-nav-link href="{{ route('admin.suppliers') }}" :active="request()->routeIs('admin.suppliers')">
                    {{ __('fields.suppliers') }}
                </x-jet-responsive-nav-link>
            @endif

            <!-- Products Link -->
            @if (auth()->user()->has('p-products'))
                <x-jet-responsive-nav-link href="{{ route('admin.products') }}" :active="request()->routeIs('admin.products')">
                    {{ __('fields.products') }}
                </x-jet-responsive-nav-link>
            @endif

            <!-- Clients Link -->
            @if (auth()->user()->has('p-clients'))
                <x-jet-responsive-nav-link href="{{ route('admin.clients') }}" :active="request()->routeIs('admin.clients')">
                    {{ __('fields.clients') }}
                </x-jet-responsive-nav-link>
            @endif


            <!-- Branches Link -->
            @if (auth()->user()->has('p-branches'))
                <x-jet-responsive-nav-link href="{{ route('admin.branches') }}" :active="request()->routeIs('admin.branches')">
                    {{ __('fields.branches') }}
                </x-jet-responsive-nav-link>
            @endif


            <!-- Categories Link -->
            @if (auth()->user()->has('p-categories'))
                <div class="hidden sm:-my-px lg:mx-1 2xl:mx-1 lg:flex">
                    <x-jet-nav-link href="{{ route('admin.categories') }}" :active="request()->routeIs('admin.categories')"
                        src="{{ asset('img/icons/categories.png') }}" alt="icon-alt"
                        text="{{ __('fields.categories') }}" />
                </div>
            @endif

            <!-- Workers Link -->
            @if (auth()->user()->has('p-workers'))
                <x-jet-responsive-nav-link href="{{ route('admin.workers') }}" :active="request()->routeIs('admin.workers')">
                    {{ __('fields.workers') }}
                </x-jet-responsive-nav-link>
            @endif

            <!-- Users Link -->
            @if (auth()->user()->has('p-users'))
                <x-jet-responsive-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
                    {{ __('fields.users') }}
                </x-jet-responsive-nav-link>
            @endif


            <!-- Reports Link -->
            @if (auth()->user()->has('p-reports'))
                <x-jet-responsive-nav-link href="{{ route('admin.reports') }}" :active="request()->routeIs('admin.reports')">
                    {{ __('fields.reports') }}
                </x-jet-responsive-nav-link>
            @endif

            <!-- Settings Options -->
            <!-- Account Management -->
            <x-jet-responsive-nav-link href="{{ route('change-locale') }}">
                {{ __('fields.change-language') }}
            </x-jet-responsive-nav-link>

            <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                {{ __('fields.profile') }}
            </x-jet-responsive-nav-link>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf

                <x-jet-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                    {{ __('fields.logout') }}
                </x-jet-responsive-nav-link>

            </form>

        </div>

    </div>

</nav>
