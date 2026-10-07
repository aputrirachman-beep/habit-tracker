<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HabitController;
use App\Models\Habit;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

Route::get('/', function () {
    $habits = Habit::where('user_id', Auth::id())
        ->with('logs')
        ->latest()
        ->get();

    $totalHabits = $habits->count();

    $completedToday = $habits->filter(function ($habit) {
        return $habit->logs->contains(function ($log) {
            return $log->is_completed
                && Carbon::parse($log->date)->isToday();
        });
    })->count();

    $progress = $totalHabits > 0
        ? round(($completedToday / $totalHabits) * 100)
        : 0;

    $bestStreak = $habits->max('streak') ?? 0;

    $weeklyLabels = [];
    $weeklyProgress = [];

    for ($i = 6; $i >= 0; $i--) {
        $day = now()->subDays($i);

        $weeklyLabels[] = $day->format('D');

        $completedOnDay = $habits->filter(function ($habit) use ($day) {
            return $habit->logs->contains(function ($log) use ($day) {
                return $log->is_completed
                    && Carbon::parse($log->date)->isSameDay($day);
            });
        })->count();

        $weeklyProgress[] = $totalHabits > 0
            ? round(($completedOnDay / $totalHabits) * 100)
            : 0;
    }

    return view('dashboard', compact(
        'habits',
        'totalHabits',
        'completedToday',
        'progress',
        'bestStreak',
        'weeklyLabels',
        'weeklyProgress'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Habit
    Route::get('/habits', [HabitController::class, 'index'])
        ->name('habits.index');

    Route::get('/habits/create', [HabitController::class, 'create'])
        ->name('habits.create');

    Route::post('/habits', [HabitController::class, 'store'])
        ->name('habits.store');

    Route::get('/habits/{habit}/edit', [HabitController::class, 'edit'])
        ->name('habits.edit');

    Route::put('/habits/{habit}', [HabitController::class, 'update'])
        ->name('habits.update');

    Route::post('/habits/{habit}/complete', [HabitController::class, 'complete'])
        ->name('habits.complete');

    Route::post('/habits/{habit}/uncomplete', [HabitController::class, 'uncomplete'])
        ->name('habits.uncomplete');

    Route::delete('/habits/{habit}', [HabitController::class, 'destroy'])
        ->name('habits.destroy');
});

require __DIR__.'/auth.php';