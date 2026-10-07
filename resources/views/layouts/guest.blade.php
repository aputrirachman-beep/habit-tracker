<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Theme -->
    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme');

            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else if (savedTheme === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                const prefersDark = window.matchMedia(
                    '(prefers-color-scheme: dark)'
                ).matches;

                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            }
        })();
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet"
    />

    <!-- Scripts -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="font-sans text-gray-900 antialiased">

    <!-- Tombol Dark / Light -->
    <div class="fixed top-4 right-4 z-50">

        <button
            type="button"
            id="guest-theme-toggle"
            class="inline-flex items-center gap-2
                   rounded-lg
                   border border-gray-300
                   bg-white
                   px-3 py-2
                   text-sm font-medium
                   text-gray-600
                   shadow-sm
                   transition
                   hover:bg-gray-100
                   dark:border-gray-700
                   dark:bg-gray-800
                   dark:text-gray-300
                   dark:hover:bg-gray-700"
        >

            <span id="guest-theme-icon">
                🌙
            </span>

            <span id="guest-theme-text">
                Dark
            </span>

        </button>

    </div>


    <!-- Guest Layout -->
    <div class="min-h-screen
            flex flex-col
            justify-center
            items-center
            px-4
            py-8
            bg-gray-100
            dark:bg-gray-900">

  <!-- Logo -->
<div class="mb-2">

    <a href="/">

        <x-application-logo
            class="w-20 h-20
                   fill-current
                   text-gray-500
                   dark:text-gray-400"
        />

    </a>

</div>


        <!-- Card -->
      <div class="w-full
            max-w-md
            mt-6
            px-6 py-6
            bg-white
            dark:bg-gray-800
            shadow-md
            overflow-hidden
            rounded-xl">

            {{ $slot }}

        </div>

    </div>


    <!-- Theme Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const toggle =
                document.getElementById('guest-theme-toggle');

            const icon =
                document.getElementById('guest-theme-icon');

            const text =
                document.getElementById('guest-theme-text');


            function updateThemeButton() {

                const isDark =
                    document.documentElement
                        .classList
                        .contains('dark');

                if (icon) {
                    icon.textContent =
                        isDark ? '☀️' : '🌙';
                }

                if (text) {
                    text.textContent =
                        isDark ? 'Light' : 'Dark';
                }
            }


            function toggleTheme() {

                const isDark =
                    document.documentElement
                        .classList
                        .contains('dark');

                if (isDark) {

                    document.documentElement
                        .classList
                        .remove('dark');

                    localStorage.setItem(
                        'theme',
                        'light'
                    );

                } else {

                    document.documentElement
                        .classList
                        .add('dark');

                    localStorage.setItem(
                        'theme',
                        'dark'
                    );

                }

                updateThemeButton();
            }


            if (toggle) {

                toggle.addEventListener(
                    'click',
                    toggleTheme
                );

            }

            updateThemeButton();

        });
    </script>

</body>

</html>