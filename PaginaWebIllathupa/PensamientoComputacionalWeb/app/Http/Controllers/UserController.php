<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email'],
            'role' => ['required', Rule::in(['estudiante', 'docente', 'investigadora'])],
            'password' => ['required', 'string', 'min:8'],
        ]);
        User::create($data + ['active' => true]);
        return back()->with('success', 'Usuario registrado correctamente.');
    }
}
