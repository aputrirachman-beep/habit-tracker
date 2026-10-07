<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Habit
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 sm:p-6">

                <form action="{{ route('habits.update', $habit) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama Habit --}}
                    <div>
                        <label
                            for="name"
                            class="block mb-2 text-sm font-medium
                                   text-gray-700 dark:text-gray-300"
                        >
                            Nama Habit
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $habit->name) }}"
                            required
                            class="w-full rounded-lg border-gray-300
                                   dark:border-gray-700
                                   dark:bg-gray-900
                                   dark:text-gray-100
                                   focus:border-indigo-500
                                   focus:ring-indigo-500"
                        >

                        @error('name')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Deskripsi --}}
                    <div class="mt-5">

                        <label
                            for="description"
                            class="block mb-2 text-sm font-medium
                                   text-gray-700 dark:text-gray-300"
                        >
                            Deskripsi
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full rounded-lg border-gray-300
                                   dark:border-gray-700
                                   dark:bg-gray-900
                                   dark:text-gray-100
                                   focus:border-indigo-500
                                   focus:ring-indigo-500"
                            placeholder="Tambahkan deskripsi singkat (opsional)"
                        >{{ old('description', $habit->description) }}</textarea>

                        @error('description')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Frekuensi --}}
                    <div class="mt-5">

                        <label
                            for="frequency"
                            class="block mb-2 text-sm font-medium
                                   text-gray-700 dark:text-gray-300"
                        >
                            Frekuensi
                        </label>

                        <select
                            id="frequency"
                            name="frequency"
                            class="w-full rounded-lg border-gray-300
                                   dark:border-gray-700
                                   dark:bg-gray-900
                                   dark:text-gray-100
                                   focus:border-indigo-500
                                   focus:ring-indigo-500"
                        >

                            <option
                                value="daily"
                                {{ old('frequency', $habit->frequency) === 'daily' ? 'selected' : '' }}
                            >
                                Harian
                            </option>

                            <option
                                value="weekly"
                                {{ old('frequency', $habit->frequency) === 'weekly' ? 'selected' : '' }}
                            >
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

                        <label
                            for="target"
                            class="block mb-2 text-sm font-medium
                                   text-gray-700 dark:text-gray-300"
                        >
                            Target
                        </label>

                        <input
                            type="number"
                            id="target"
                            name="target"
                            min="1"
                            value="{{ old('target', $habit->target) }}"
                            required
                            class="w-full rounded-lg border-gray-300
                                   dark:border-gray-700
                                   dark:bg-gray-900
                                   dark:text-gray-100
                                   focus:border-indigo-500
                                   focus:ring-indigo-500"
                        >

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Ubah target sesuai kebutuhan habit.
                        </p>

                        @error('target')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Tombol --}}
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                        <button
                            type="submit"
                            class="inline-flex w-full sm:w-auto
                                   items-center justify-center
                                   rounded-lg bg-indigo-600
                                   px-5 py-2.5
                                   text-sm font-semibold text-white
                                   transition hover:bg-indigo-700"
                        >
                            Simpan Perubahan
                        </button>

                        <a
                            href="{{ route('habits.index') }}"
                            class="inline-flex w-full sm:w-auto
                                   items-center justify-center
                                   rounded-lg bg-gray-200
                                   px-5 py-2.5
                                   text-sm font-medium text-gray-700
                                   transition hover:bg-gray-300
                                   dark:bg-gray-700
                                   dark:text-gray-200
                                   dark:hover:bg-gray-600"
                        >
                            Batal
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>