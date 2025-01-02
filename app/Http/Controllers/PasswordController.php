<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function index()
    {
        return view('password.index'); // Return a Blade view
    }

    public function generate(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $hashedPassword = Hash::make($request->input('password'));

        return view('password.index', ['hashedPassword' => $hashedPassword]);
    }
}
