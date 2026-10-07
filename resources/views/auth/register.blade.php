<x-guest-layout>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label
                for="name"
                value="Nama"
            />

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error
                :messages="$errors->get('name')"
                class="mt-2"
            />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label
                for="email"
                value="Email"
            />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label
                for="password"
                value="Password"
            />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label
                for="password_confirmation"
                value="Konfirmasi Password"
            />

            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <!-- Actions -->
        <div class="mt-6 space-y-4">

            <button
                type="submit"
                class="w-full rounded-lg
                       bg-indigo-600
                       px-4 py-3
                       text-sm font-semibold
                       text-white
                       transition
                       hover:bg-indigo-700
                       focus:outline-none
                       focus:ring-2
                       focus:ring-indigo-500
                       focus:ring-offset-2
                       dark:focus:ring-offset-gray-800"
            >
                Daftar
            </button>

            <div class="text-center">

                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Sudah punya akun?

                    <a
                        href="{{ route('login') }}"
                        class="font-semibold text-indigo-600
                               hover:text-indigo-500
                               dark:text-indigo-400
                               dark:hover:text-indigo-300"
                    >
                        Masuk
                    </a>
                </p>

            </div>

        </div>

    </form>

</x-guest-layout>