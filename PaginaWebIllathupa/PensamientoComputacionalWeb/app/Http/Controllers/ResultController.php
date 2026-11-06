<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\User;

class ResultController extends Controller
{
    public function mine()
    {
        $results = auth()->user()->results()->with('activity')->latest()->paginate(12);
        return view('results.mine', compact('results'));
    }

    public function progress()
    {
        $students = User::where('role', 'estudiante')->where('active', true)
            ->with(['results' => fn ($q) => $q->with('activity')->latest()])
            ->orderBy('name')->paginate(15);
        return view('results.progress', compact('students'));
    }
}
