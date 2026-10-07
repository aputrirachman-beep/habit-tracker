<nav
    x-data="{ open: false }"
    class="sticky top-0 z-50
           bg-white dark:bg-gray-800
           border-b border-gray-100 dark:border-gray-700
           shadow-sm"
>

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">

            <!-- Bagian Kiri -->
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">

                    <a href="{{ route('dashboard') }}">

                        <x-application-logo
                            class="block h-9 w-auto
                                   fill-current
                                   text-gray-800 dark:text-gray-200"
                        />

                    </a>

                </div>


                <!-- Navigation Links Desktop -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')"
                    >
                        Dashboard
                    </x-nav-link>


                    <x-nav-link
                        :href="route('habits.index')"
                        :active="request()->routeIs('habits.*')"
                    >
                        Habit Saya
                    </x-nav-link>

                </div>

            </div>


            <!-- Bagian Kanan Desktop -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">

                <!-- Dark / Light Mode -->
                <button
                    type="button"
                    id="theme-toggle"
                    class="inline-flex items-center gap-2
                           rounded-lg
                           border border-gray-300
                           px-3 py-2
                           text-sm font-medium
                           text-gray-600
                           transition
                           hover:bg-gray-100
                           dark:border-gray-700
                           dark:text-gray-300
                           dark:hover:bg-gray-700"
                >

                    <span id="theme-icon">
                        🌙
                    </span>

                    <span id="theme-text">
                        Dark
                    </span>

                </button>


                <!-- Dropdown User -->
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                        <button
                            type="button"
                            class="inline-flex items-center
                                   rounded-lg
                                   border border-transparent
                                   bg-white px-3 py-2
                                   text-sm font-medium
                                   text-gray-500
                                   transition
                                   hover:text-gray-700
                                   focus:outline-none
                                   dark:bg-gray-800
                                   dark:text-gray-400
                                   dark:hover:text-gray-200"
                        >

                            <span>
                                {{ Auth::user()->name }}
                            </span>


                            <span class="ms-1">

                                <svg
                                    class="h-4 w-4 fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                >

                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0
                                           L10 10.586
                                           l3.293-3.293
                                           a1 1 0 111.414 1.414
                                           l-4 4
                                           a1 1 0 01-1.414 0
                                           l-4-4
                                           a1 1 0 010-1.414z"
                                    />

                                </svg>

                            </span>

                        </button>

                    </x-slot>


                    <x-slot name="content">

                        <x-dropdown-link
                            :href="route('profile.edit')"
                        >
                            Profile
                        </x-dropdown-link>


                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >

                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="
                                    event.preventDefault();
                                    this.closest('form').submit();
                                "
                            >
                                Logout
                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>


            <!-- Hamburger Mobile -->
            <div class="-me-2 flex items-center sm:hidden">

                <button
                    type="button"
                    @click="open = ! open"
                    class="inline-flex items-center
                           justify-center
                           rounded-lg
                           p-2
                           text-gray-400
                           transition
                           hover:bg-gray-100
                           hover:text-gray-500
                           focus:outline-none
                           dark:hover:bg-gray-700"
                >

                    <svg
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >

                        <!-- Hamburger -->
                        <path
                            :class="{
                                'hidden': open,
                                'inline-flex': !open
                            }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />


                        <!-- Close -->
                        <path
                            :class="{
                                'hidden': !open,
                                'inline-flex': open
                            }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />

                    </svg>

                </button>

            </div>

        </div>

    </div>


    <!-- Responsive Navigation Menu -->
    <div
        :class="{
            'block': open,
            'hidden': !open
        }"
        class="hidden sm:hidden"
    >

        <!-- Menu Mobile -->
        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')"
            >
                Dashboard
            </x-responsive-nav-link>


            <x-responsive-nav-link
                :href="route('habits.index')"
                :active="request()->routeIs('habits.*')"
            >
                Habit Saya
            </x-responsive-nav-link>

        </div>


        <!-- Informasi User -->
        <div class="pt-4 pb-1
                    border-t border-gray-200
                    dark:border-gray-600">

            <div class="px-4">

                <div class="text-base font-medium
                            text-gray-800
                            dark:text-gray-200">
                    {{ Auth::user()->name }}
                </div>


                <div class="text-sm font-medium
                            text-gray-500
                            dark:text-gray-400">
                    {{ Auth::user()->email }}
                </div>

            </div>


            <!-- Theme Mobile -->
            <div class="px-4 mt-4">

                <button
                    type="button"
                    id="theme-toggle-mobile"
                    class="inline-flex w-full
                           items-center justify-center
                           gap-2
                           rounded-lg
                           border border-gray-300
                           px-4 py-2.5
                           text-sm font-medium
                           text-gray-600
                           transition
                           hover:bg-gray-100
                           dark:border-gray-700
                           dark:text-gray-300
                           dark:hover:bg-gray-700"
                >

                    <span id="theme-icon-mobile">
                        🌙
                    </span>

                    <span id="theme-text-mobile">
                        Dark
                    </span>

                </button>

            </div>


            <!-- Menu User Mobile -->
            <div class="mt-3 space-y-1">

                <x-responsive-nav-link
                    :href="route('profile.edit')"
                >
                    Profile
                </x-responsive-nav-link>


                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="
                            event.preventDefault();
                            this.closest('form').submit();
                        "
                    >
                        Logout
                    </x-responsive-nav-link>

                </form>

            </div>

        </div>

    </div>

</nav>