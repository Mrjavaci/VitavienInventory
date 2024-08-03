<?php

namespace Modules\User\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user::index');
    }

    public function login(Request $request)
    {
        if (auth()->attempt([
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ])) {
            return redirect()->route('home');
        }

        return view('user::index', ['error' => 'Email or password is incorrect']);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
