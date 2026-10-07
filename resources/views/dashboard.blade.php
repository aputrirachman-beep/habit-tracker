<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Habit Tracker
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Message --}}
            @if(session('success'))
                <div
                    id="flash-message"
                    class="mb-6 flex items-center justify-between rounded-xl
                           border border-green-200 bg-green-50 px-4 py-3
                           text-green-800 shadow-sm
                           dark:border-green-800 dark:bg-green-900/30
                           dark:text-green-300"
                >
                    <div class="flex items-center gap-2">
                        <span class="font-bold">✓</span>

                        <span>
                            {{ session('success') }}
                        </span>
                    </div>

                    <button
                        type="button"
                        onclick="document.getElementById('flash-message').remove()"
                        class="ml-4 text-lg opacity-60 hover:opacity-100"
                    >
                        ×
                    </button>
                </div>
            @endif

            {{-- Kartu Statistik --}}
           <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">
                {{-- Total Habit --}}
                <div class="rounded-xl bg-white p-5 shadow-sm
                            dark:bg-gray-800">

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Habit
                    </p>

                    <div class="mt-3 flex items-end justify-between">

                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $totalHabits }}
                        </h3>

                        <span class="rounded-lg bg-indigo-100 px-3 py-1
                                     text-xs font-semibold text-indigo-700
                                     dark:bg-indigo-900/30 dark:text-indigo-300">
                            Total
                        </span>

                    </div>
                </div>

                {{-- Selesai Hari Ini --}}
                <div class="rounded-xl bg-white p-5 shadow-sm
                            dark:bg-gray-800">

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Selesai Hari Ini
                    </p>

                    <div class="mt-3 flex items-end justify-between">

                        <h3 class="text-3xl font-bold text-green-600">
                            {{ $completedToday }}
                        </h3>

                        <span class="rounded-lg bg-green-100 px-3 py-1
                                     text-xs font-semibold text-green-700
                                     dark:bg-green-900/30 dark:text-green-300">
                            Done
                        </span>

                    </div>
                </div>

                {{-- Progress Hari Ini --}}
                <div class="rounded-xl bg-white p-5 shadow-sm
                            dark:bg-gray-800">

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Progress Hari Ini
                    </p>

                    <div class="mt-3 flex items-end justify-between">

                        <h3 class="text-3xl font-bold text-indigo-600">
                            {{ $progress }}%
                        </h3>

                        <span class="rounded-lg bg-indigo-100 px-3 py-1
                                     text-xs font-semibold text-indigo-700
                                     dark:bg-indigo-900/30 dark:text-indigo-300">
                            Progress
                        </span>

                    </div>
                </div>

                {{-- Streak --}}
                <div class="rounded-xl bg-white p-5 shadow-sm
                            dark:bg-gray-800">

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Streak Terbaik
                    </p>

                    <div class="mt-3 flex items-end justify-between">

                        <h3 class="text-3xl font-bold text-orange-500">
                            🔥 {{ $bestStreak }}
                        </h3>

                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            hari
                        </span>

                    </div>
                </div>

            </div>

            {{-- Progress Hari Ini --}}
            <div class="mt-8 rounded-xl bg-white p-5 sm:p-6 shadow-sm
                        dark:bg-gray-800">

                <div class="mb-4 flex flex-col gap-2
                            sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Progress Hari Ini
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $completedToday }} dari {{ $totalHabits }} habit selesai
                        </p>
                    </div>

                    <div class="text-2xl font-bold text-indigo-600">
                        {{ $progress }}%
                    </div>

                </div>

                <div class="h-3 w-full rounded-full bg-gray-200 dark:bg-gray-700">

                    <div
                        class="h-3 rounded-full bg-indigo-600
                               transition-all duration-300"
                        style="width: {{ $progress }}%">
                    </div>

                </div>

                @if($totalHabits > 0 && $completedToday === $totalHabits)

                    <div class="mt-5 rounded-lg border border-green-200
                                bg-green-50 p-4 text-sm font-medium
                                text-green-700
                                dark:border-green-800
                                dark:bg-green-900/30
                                dark:text-green-300">
                        ✓ Semua habit hari ini sudah selesai.
                    </div>

                @endif

            </div>

            {{-- Grafik --}}
            <div class="mt-8 rounded-xl bg-white p-5 sm:p-6 shadow-sm
                        dark:bg-gray-800">

                <h3 class="mb-4 text-lg font-semibold
                           text-gray-900 dark:text-gray-100">
                    Progress 7 Hari Terakhir
                </h3>

                <div class="w-full" style="height: 300px;">
                    <canvas id="weeklyChart"></canvas>
                </div>

            </div>

            {{-- Habit Hari Ini --}}
            <div class="mt-8 rounded-xl bg-white p-5 sm:p-6 shadow-sm
                        dark:bg-gray-800">

                {{-- Header --}}
                <div class="mb-6 flex flex-col gap-3
                            sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-lg font-semibold
                                   text-gray-900 dark:text-gray-100">
                            Habit Hari Ini
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Kelola dan tandai habit yang sudah kamu selesaikan.
                        </p>
                    </div>

                    <a
                        href="{{ route('habits.create') }}"
                        class="inline-flex w-full items-center justify-center
                               rounded-lg bg-indigo-600 px-4 py-2.5
                               text-sm font-semibold text-white
                               transition hover:bg-indigo-700
                               sm:w-auto"
                    >
                        + Tambah Habit
                    </a>

                </div>

                {{-- Daftar Habit --}}
                <div class="space-y-4">

                    @forelse($habits as $habit)

                        @php
                            $completed = $habit->logs->contains(function ($log) {
                                return $log->is_completed
                                    && \Carbon\Carbon::parse($log->date)->isToday();
                            });
                        @endphp

                        <div class="rounded-xl border border-gray-200
                                    bg-gray-50 p-4
                                    dark:border-gray-700
                                    dark:bg-gray-900/30
                                    sm:p-5">

                            <div class="flex flex-col gap-4
                                        md:flex-row md:items-center
                                        md:justify-between">

                                {{-- Informasi Habit --}}
                                <div>

                                    <div class="flex flex-wrap items-center gap-2">

                                        <h4 class="font-semibold text-gray-900
                                                   dark:text-gray-100">
                                            {{ $habit->name }}
                                        </h4>

                                        @if($completed)
                                            <span class="rounded-full
                                                         bg-green-100
                                                         px-2.5 py-1
                                                         text-xs font-semibold
                                                         text-green-700
                                                         dark:bg-green-900/30
                                                         dark:text-green-300">
                                                ✓ Selesai
                                            </span>
                                        @else
                                            <span class="rounded-full
                                                         bg-gray-200
                                                         px-2.5 py-1
                                                         text-xs font-semibold
                                                         text-gray-600
                                                         dark:bg-gray-700
                                                         dark:text-gray-300">
                                                Belum
                                            </span>
                                        @endif

                                    </div>

                                    <p class="mt-2 text-sm text-gray-500
                                              dark:text-gray-400">

                                        {{ ucfirst($habit->frequency) }}

                                        <span class="mx-1">·</span>

                                        Target {{ $habit->target }}

                                        <span class="mx-1">·</span>

                                        🔥 {{ $habit->streak }} hari

                                    </p>

                                </div>

                                {{-- Aksi --}}
<div class="grid grid-cols-1 gap-2 sm:flex sm:flex-wrap sm:items-center sm:gap-3">

    @if($completed)

        <form
            action="{{ route('habits.uncomplete', $habit) }}"
            method="POST"
            class="w-full sm:w-auto"
        >
            @csrf

            <button
                type="submit"
                class="inline-flex w-full sm:w-auto items-center
                       justify-center rounded-lg
                       bg-gray-200 px-4 py-2
                       text-sm font-medium
                       text-gray-700
                       transition
                       hover:bg-gray-300
                       dark:bg-gray-700
                       dark:text-gray-200
                       dark:hover:bg-gray-600"
            >
                Batalkan
            </button>

        </form>

    @else

        <form
            action="{{ route('habits.complete', $habit) }}"
            method="POST"
            class="w-full sm:w-auto"
        >
            @csrf

            <button
                type="submit"
                class="inline-flex w-full sm:w-auto items-center
                       justify-center rounded-lg
                       bg-green-600 px-4 py-2
                       text-sm font-medium
                       text-white transition
                       hover:bg-green-700"
            >
                ✓ Selesai Hari Ini
            </button>

        </form>

    @endif


    <a
        href="{{ route('habits.edit', $habit) }}"
        class="inline-flex w-full sm:w-auto items-center
               justify-center rounded-lg
               bg-blue-600 px-4 py-2
               text-sm font-medium
               text-white transition
               hover:bg-blue-700"
    >
        Edit
    </a>

</div>

                            </div>

                        </div>

                    @empty

                        {{-- Empty State --}}
                        <div class="rounded-xl border border-dashed
                                    border-gray-300 p-8 text-center
                                    dark:border-gray-700">

                            <div class="text-4xl">
                                ✓
                            </div>

                            <h4 class="mt-3 font-semibold text-gray-900
                                       dark:text-gray-100">
                                Belum ada habit
                            </h4>

                            <p class="mt-2 text-sm text-gray-500
                                      dark:text-gray-400">
                                Buat habit pertama untuk mulai mencatat progresmu.
                            </p>

                            <a
                                href="{{ route('habits.create') }}"
                                class="mt-5 inline-flex items-center
                                       justify-center rounded-lg
                                       bg-indigo-600 px-4 py-2.5
                                       text-sm font-semibold text-white
                                       transition hover:bg-indigo-700"
                            >
                                + Buat Habit Pertama
                            </a>

                        </div>

                    @endforelse

                </div>

                @if($totalHabits > 0)

                    <div class="mt-6 border-t border-gray-200 pt-5
                                dark:border-gray-700">

                        <a
                            href="{{ route('habits.index') }}"
                            class="text-sm font-semibold text-indigo-600
                                   transition hover:text-indigo-500
                                   dark:text-indigo-400"
                        >
                            Lihat semua habit →
                        </a>

                    </div>

                @endif

            </div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('weeklyChart');

        new Chart(ctx, {
            type: 'bar',

            data: {
                labels: @json($weeklyLabels),

                datasets: [{
                    label: 'Progress (%)',
                    data: @json($weeklyProgress),
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,

                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>

</x-app-layout>