<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login()
    {
        return view('admin.login.index');
    }

    public function logout() {
        Auth::logout();
        return redirect(route('login'));
    }

    public function auth(Request $request) {
        $credentials = $request->only('name', 'password');
        if(Auth::attempt($credentials)) {
            session()->forget('loginAttempts'); # обнулить счетчик попыток входа (удалить сессию)
            return redirect(route('dashboard'));
        }

        return redirect(route('login'))->withErrors([
            'credentials' => "incorrect login or password",
        ]);
    }

}
