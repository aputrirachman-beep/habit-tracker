<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Habit Tracker') }}</title>

    {{-- Theme dipasang sebelum halaman tampil --}}
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

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet"
    >

    {{-- CSS & JS --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        {{-- Navbar --}}
        @include('layouts.navigation')


        {{-- Header Halaman --}}
        @isset($header)

            <header class="bg-white shadow-sm dark:bg-gray-800">

                <div class="max-w-7xl mx-auto
                            px-4 py-6
                            sm:px-6 lg:px-8">

                    {{ $header }}

                </div>

            </header>

        @endisset


        {{-- Isi Halaman --}}
        <main>
            {{ $slot }}
        </main>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // =========================================
            // DARK / LIGHT MODE
            // =========================================

            const toggleDesktop =
                document.getElementById('theme-toggle');

            const toggleMobile =
                document.getElementById('theme-toggle-mobile');

            const iconDesktop =
                document.getElementById('theme-icon');

            const textDesktop =
                document.getElementById('theme-text');

            const iconMobile =
                document.getElementById('theme-icon-mobile');

            const textMobile =
                document.getElementById('theme-text-mobile');


            function updateThemeButtons() {

                const isDark =
                    document.documentElement
                        .classList
                        .contains('dark');


                if (iconDesktop) {
                    iconDesktop.textContent =
                        isDark ? '☀️' : '🌙';
                }

                if (textDesktop) {
                    textDesktop.textContent =
                        isDark ? 'Light' : 'Dark';
                }

                if (iconMobile) {
                    iconMobile.textContent =
                        isDark ? '☀️' : '🌙';
                }

                if (textMobile) {
                    textMobile.textContent =
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

                updateThemeButtons();
            }


            if (toggleDesktop) {
                toggleDesktop.addEventListener(
                    'click',
                    toggleTheme
                );
            }


            if (toggleMobile) {
                toggleMobile.addEventListener(
                    'click',
                    toggleTheme
                );
            }


            updateThemeButtons();


            // =========================================
            // FLASH MESSAGE
            // =========================================

            const flash =
                document.getElementById('flash-message');

            if (flash) {

                setTimeout(function () {

                    flash.style.transition =
                        'opacity 0.4s ease';

                    flash.style.opacity = '0';

                    setTimeout(function () {
                        flash.remove();
                    }, 400);

                }, 3000);

            }


            const error =
                document.getElementById('error-message');

            if (error) {

                setTimeout(function () {

                    error.style.transition =
                        'opacity 0.4s ease';

                    error.style.opacity = '0';

                    setTimeout(function () {
                        error.remove();
                    }, 400);

                }, 3000);

            }

        });


        // =========================================
        // CEGAH DOUBLE SUBMIT
        // =========================================

        document.addEventListener(
            'submit',
            function (event) {

                const form = event.target;

                if (!(form instanceof HTMLFormElement)) {
                    return;
                }

                const button =
                    form.querySelector(
                        'button[type="submit"]'
                    );

                if (!button) {
                    return;
                }

                if (button.dataset.submitting === 'true') {

                    event.preventDefault();

                    return;
                }


                button.dataset.submitting = 'true';

                button.disabled = true;

                button.classList.add(
                    'opacity-60',
                    'cursor-not-allowed'
                );

                button.dataset.originalText =
                    button.innerHTML;

                button.innerHTML =
                    'Memproses...';

            }
        );
    </script>

</body>

</html>