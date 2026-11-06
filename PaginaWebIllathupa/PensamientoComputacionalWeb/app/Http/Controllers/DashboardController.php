<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $activities = Activity::where('published', true)->latest()->take(5)->get();
        $stats = [
            'activities' => Activity::where('published', true)->count(),
            'students' => User::where('role', 'estudiante')->where('active', true)->count(),
            'attempts' => Result::count(),
            'average' => round((float) (Result::avg('percentage') ?? 0)),
        ];
        $recentResults = $user->role === 'estudiante'
            ? $user->results()->with('activity')->latest()->take(5)->get()
            : Result::with(['user', 'activity'])->latest()->take(7)->get();

        return view('dashboard', compact('user', 'activities', 'stats', 'recentResults'));
    }
}
