<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-m-orange">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="username" value="{{ __('fields.username') }}" />
                <x-jet-input id="username" class="block w-full mt-1" type="text" name="username"
                    placeholder="{{ __('placeholders.enter-username') }}" :value="old('username')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('fields.password') }}" />
                <x-jet-input id="password" class="block w-full mt-1" type="password" name="password" required
                    autocomplete="current-password" placeholder="{{ __('placeholders.enter-password') }}" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="mx-2 text-sm text-gray-600">{{ __('fields.remember-me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-jet-button>
                    {{ __('fields.login') }}
                </x-jet-button>

            </div>
        </form>
    </x-jet-authentication-card>

    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:focus {
            transition: background-color 600000s 0s, color 600000s 0s;
        }

        input[data-autocompleted] {
            background-color: transparent !important;
            transition-delay: 200ms;

        }

    </style>

</x-guest-layout>
