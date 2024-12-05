<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login()
    {
        return view('login.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    public function auth(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            /**
             * @var User $user
             */
            $user = Auth::user();

            if ($user->isAdmin()) {
                $route = route('admin.dashboard');
            } else {
                $route = route('agent.dashboard', ['company_hash' => $user->company->hash]);
            }

            return redirect($route);
        }

        return redirect(route('login'))->withErrors([
            'credentials' => "incorrect login or password",
        ]);
    }

}
