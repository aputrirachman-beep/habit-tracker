<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
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
                autofocus
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
                autocomplete="current-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />

        </div>

        <!-- Remember Me -->
        <div class="block mt-4">

            <label
                for="remember_me"
                class="inline-flex items-center"
            >

                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded dark:bg-gray-900
                           border-gray-300 dark:border-gray-700
                           text-indigo-600 shadow-sm
                           focus:ring-indigo-500
                           dark:focus:ring-indigo-600
                           dark:focus:ring-offset-gray-800"
                    name="remember"
                >

                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                    Ingat saya
                </span>

            </label>

        </div>

        <!-- Actions -->
        <div class="mt-6 space-y-4">

            <!-- Tombol Masuk -->
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
                Masuk
            </button>

            <!-- Lupa Password -->
            @if (Route::has('password.request'))
                <div class="text-center">

                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm text-gray-500 underline
                               hover:text-gray-800
                               dark:text-gray-400
                               dark:hover:text-gray-200"
                    >
                        Lupa password?
                    </a>

                </div>
            @endif

            <!-- Daftar -->
            @if (Route::has('register'))
                <div class="text-center">

                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Belum punya akun?

                        <a
                            href="{{ route('register') }}"
                            class="font-semibold text-indigo-600
                                   hover:text-indigo-500
                                   dark:text-indigo-400
                                   dark:hover:text-indigo-300"
                        >
                            Daftar sekarang
                        </a>
                    </p>

                </div>
            @endif

        </div>

    </form>

</x-guest-layout>