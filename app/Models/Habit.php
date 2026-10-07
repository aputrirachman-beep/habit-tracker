<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'frequency',
        'target',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(HabitLog::class);
    }

    public function getStreakAttribute()
    {
        $dates = $this->logs()
            ->where('is_completed', true)
            ->orderByDesc('date')
            ->pluck('date')
            ->map(fn ($date) => \Carbon\Carbon::parse($date)->startOfDay());

        if ($dates->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $currentDate = now()->startOfDay();

        foreach ($dates as $date) {
            if ($date->equalTo($currentDate)) {
                $streak++;
                $currentDate = $currentDate->copy()->subDay();
            } elseif ($date->equalTo($currentDate->copy()->subDay())) {
                $streak++;
                $currentDate = $date->copy()->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }
}