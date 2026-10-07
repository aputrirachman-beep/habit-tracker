<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Habit
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">

                <form action="{{ route('habits.store') }}" method="POST">
                    @csrf

                    {{-- Nama Habit --}}
                    <div>
                        <label for="name"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Habit
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700
                                   dark:bg-gray-900 dark:text-gray-100
                                   focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Contoh: Lari pagi"
                        >

                        @error('name')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mt-5">
                        <label for="description"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Deskripsi
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700
                                   dark:bg-gray-900 dark:text-gray-100
                                   focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Tambahkan deskripsi singkat (opsional)"
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Frekuensi --}}
                    <div class="mt-5">
                        <label for="frequency"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Frekuensi
                        </label>

                        <select
                            id="frequency"
                            name="frequency"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700
                                   dark:bg-gray-900 dark:text-gray-100
                                   focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="daily" {{ old('frequency') === 'daily' ? 'selected' : '' }}>
                                Harian
                            </option>

                            <option value="weekly" {{ old('frequency') === 'weekly' ? 'selected' : '' }}>
                                Mingguan
                            </option>
                        </select>

                        @error('frequency')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Target --}}
                    <div class="mt-5">
                        <label for="target"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Target
                        </label>

                        <input
                            type="number"
                            id="target"
                            name="target"
                            min="1"
                            value="{{ old('target', 1) }}"
                            required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700
                                   dark:bg-gray-900 dark:text-gray-100
                                   focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Jumlah target aktivitas sesuai frekuensi yang dipilih.
                        </p>

                        @error('target')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="mt-8 flex flex-wrap items-center gap-3">

                        <button
                            type="submit"
                            class="rounded-lg bg-indigo-600 px-5 py-2.5
                                   text-sm font-semibold text-white
                                   transition hover:bg-indigo-700"
                        >
                            Simpan Habit
                        </button>

                        <a href="{{ route('habits.index') }}"
                           class="rounded-lg bg-gray-200 px-5 py-2.5
                                  text-sm font-medium text-gray-700
                                  transition hover:bg-gray-300
                                  dark:bg-gray-700 dark:text-gray-200
                                  dark:hover:bg-gray-600">
                            Batal
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>