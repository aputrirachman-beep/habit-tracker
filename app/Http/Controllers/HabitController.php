<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HabitController extends Controller
{
    public function index()
    {
        $startDate = now()->subDays(6)->toDateString();
        $endDate = now()->toDateString();

        $habits = Habit::where('user_id', Auth::id())
            ->with(['logs' => function ($query) use ($startDate, $endDate) {
                $query
                    ->whereDate('date', '>=', $startDate)
                    ->whereDate('date', '<=', $endDate);
            }])
            ->latest()
            ->get();

        $totalHabits = $habits->count();

        $completedHabits = $habits->filter(function ($habit) {
            return $habit->logs->contains(function ($log) {
                return $log->is_completed
                    && Carbon::parse($log->date)->isToday();
            });
        })->count();

        $progress = $totalHabits > 0
            ? round(($completedHabits / $totalHabits) * 100)
            : 0;

        $lastSevenDays = collect();

        for ($i = 6; $i >= 0; $i--) {
            $lastSevenDays->push(
                now()->subDays($i)->startOfDay()
            );
        }

        return view('habits.index', compact(
            'habits',
            'totalHabits',
            'completedHabits',
            'progress',
            'lastSevenDays'
        ));
    }

    public function create()
    {
        return view('habits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'frequency' => 'required|in:daily,weekly',
            'target' => 'required|integer|min:1',
        ]);

        Habit::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'frequency' => $validated['frequency'],
            'target' => $validated['target'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('habits.index')
            ->with('success', 'Habit berhasil ditambahkan.');
    }

    public function edit(Habit $habit)
    {
        $this->authorizeHabit($habit);

        return view('habits.edit', compact('habit'));
    }

    public function update(Request $request, Habit $habit)
    {
        $this->authorizeHabit($habit);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'frequency' => 'required|in:daily,weekly',
            'target' => 'required|integer|min:1',
        ]);

        $habit->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'frequency' => $validated['frequency'],
            'target' => $validated['target'],
        ]);

        return redirect()
            ->route('habits.index')
            ->with('success', 'Habit berhasil diperbarui.');
    }

public function complete(Habit $habit)
{
    $this->authorizeHabit($habit);

    $today = now()->toDateString();

    $log = HabitLog::where('habit_id', $habit->id)
        ->whereDate('date', $today)
        ->first();

    if ($log) {
        $log->update([
            'is_completed' => true
        ]);
    } else {
        HabitLog::create([
            'habit_id' => $habit->id,
            'date' => $today,
            'is_completed' => true,
        ]);
    }

    return redirect()
        ->back()
        ->with('success', 'Habit hari ini berhasil ditandai selesai.');
}

  public function uncomplete(Habit $habit)
{
    $this->authorizeHabit($habit);

    $today = now()->toDateString();

    $log = HabitLog::where('habit_id', $habit->id)
        ->whereDate('date', $today)
        ->first();

    if ($log) {
        $log->delete();
    }

    return redirect()
        ->back()
        ->with('success', 'Status selesai hari ini berhasil dibatalkan.');
}

    public function destroy(Habit $habit)
    {
        $this->authorizeHabit($habit);

        $habit->delete();

        return redirect()
            ->route('habits.index')
            ->with('success', 'Habit berhasil dihapus.');
    }

    private function authorizeHabit(Habit $habit): void
    {
        if ($habit->user_id !== Auth::id()) {
            abort(403);
        }
    }
}