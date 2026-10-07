<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Habit Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div
                    id="flash-message"
                    class="mb-6 flex items-center justify-between rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800 shadow-sm dark:border-green-800 dark:bg-green-900/30 dark:text-green-300"
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

            {{-- Progress Hari Ini --}}
            <div class="mb-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">

                <div class="flex justify-between items-center mb-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Progress Hari Ini
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $completedHabits }} dari {{ $totalHabits }} habit selesai
                        </p>
                    </div>

                    <div class="text-2xl font-bold text-indigo-600">
                        {{ $progress }}%
                    </div>
                </div>

                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                    <div
                        class="bg-indigo-600 h-3 rounded-full transition-all duration-300"
                        style="width: {{ $progress }}%">
                    </div>
                </div>

            </div>

            <div class="mb-4">
                <a href="{{ route('habits.create') }}"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                    + Tambah Habit
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @forelse($habits as $habit)

                        @php
                            $completedToday = $habit->logs->contains(function ($log) {
                                return $log->is_completed
                                    && \Carbon\Carbon::parse($log->date)->isToday();
                            });
                        @endphp

                        <div class="border-b py-4">

                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">
                                {{ $habit->name }}
                            </h3>

                            <p class="text-gray-700 dark:text-gray-300">
                                {{ $habit->description }}
                            </p>

                            <p class="text-gray-700 dark:text-gray-300">
                                Frekuensi: {{ $habit->frequency }}
                            </p>

                            <p class="text-gray-700 dark:text-gray-300">
                                Target: {{ $habit->target }}
                            </p>

                            {{-- Streak --}}
                            <p class="text-orange-500 font-semibold mt-2">
                                🔥 Streak: {{ $habit->streak }} hari
                            </p>

                            {{-- Riwayat 7 Hari Terakhir --}}
                            <div class="mt-4">

                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    7 Hari Terakhir
                                </p>

                                <div class="flex gap-3 flex-wrap">

                                    @foreach($lastSevenDays as $day)

                                        @php
                                            $log = $habit->logs->first(function ($log) use ($day) {
                                                return \Carbon\Carbon::parse($log->date)
                                                    ->isSameDay($day);
                                            });
                                        @endphp

                                        <div class="text-center">

                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $day->format('D') }}
                                            </div>

                                            <div class="w-9 h-9 flex items-center justify-center rounded-full mt-1
                                                {{ $log && $log->is_completed
                                                    ? 'bg-green-600 text-white'
                                                    : 'bg-gray-200 dark:bg-gray-700 text-gray-500' }}">

                                                @if($log && $log->is_completed)
                                                    ✓
                                                @else
                                                    ○
                                                @endif

                                            </div>

                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $day->format('d') }}
                                            </div>

                                        </div>

                                    @endforeach

                                </div>
                            </div>

                            {{-- Status Hari Ini --}}
                            <div class="mt-4">

                                @if($completedToday)

    <div class="flex flex-wrap items-center gap-3">

        <span class="inline-flex items-center rounded-full
                     bg-green-100 px-3 py-1.5 text-sm font-semibold
                     text-green-700
                     dark:bg-green-900/30 dark:text-green-400">
            ✓ Selesai Hari Ini
        </span>

        <form action="{{ route('habits.uncomplete', $habit) }}"
              method="POST">
            @csrf

            <button type="submit"
                    class="rounded-lg px-3 py-1.5 text-sm font-medium
                           text-gray-500 transition
                           hover:bg-red-50 hover:text-red-600
                           dark:text-gray-400 dark:hover:bg-red-900/20">
                Batalkan
            </button>
        </form>

    </div>

                                @else

                                    <form action="{{ route('habits.complete', $habit) }}"
                                          method="POST">
                                        @csrf

                                        <button type="submit"
                                                class="px-3 py-2 bg-green-600 text-white rounded-lg">
                                            Selesai Hari Ini
                                        </button>
                                    </form>

                                @endif

                            </div>

                           {{-- Aksi --}}
<div class="mt-5 flex flex-wrap items-center gap-3">

    <a href="{{ route('habits.edit', $habit) }}"
       class="inline-flex items-center justify-center rounded-lg
              bg-blue-600 px-4 py-2 text-sm font-medium text-white
              transition hover:bg-blue-700">
        Edit
    </a>

    <button
        type="button"
        class="inline-flex items-center justify-center rounded-lg
               bg-red-600 px-4 py-2 text-sm font-medium text-white
               transition hover:bg-red-700"
        onclick="openDeleteModal(
            '{{ route('habits.destroy', $habit) }}',
            @js($habit->name)
        )"
    >
        Hapus
    </button>

</div>

                        </div>

                    @empty

                        <p class="text-gray-600 dark:text-gray-300">
                            Belum ada habit.
                        </p>

                    @endforelse

                </div>
            </div>

        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div
        id="delete-modal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-4"
    >
        <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl dark:bg-gray-800">

            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                Hapus Habit?
            </h3>

            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Habit
                <span id="delete-habit-name" class="font-semibold"></span>
                akan dihapus beserta riwayat progresnya.
            </p>

            <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="mt-6 flex justify-end gap-3">

                <button
                    type="button"
                    onclick="closeDeleteModal()"
                    class="rounded-lg bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                >
                    Batal
                </button>

                <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="rounded-lg bg-red-600 px-4 py-2 font-medium text-white hover:bg-red-700"
                    >
                        Ya, Hapus
                    </button>
                </form>

            </div>

        </div>
    </div>

    <script>
        function openDeleteModal(action, habitName) {
            const modal = document.getElementById('delete-modal');
            const form = document.getElementById('delete-form');
            const name = document.getElementById('delete-habit-name');

            form.action = action;
            name.textContent = habitName;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.body.classList.add('overflow-hidden');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('delete-modal');

            modal.classList.add('hidden');
            modal.classList.remove('flex');

            document.body.classList.remove('overflow-hidden');
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeDeleteModal();
            }
        });

        document.getElementById('delete-modal').addEventListener('click', function (event) {
            if (event.target === this) {
                closeDeleteModal();
            }
        });
    </script>

</x-app-layout>