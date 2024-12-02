<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});


Route::middleware('auth:web')->group(function()
{
    Route::get('/dashboard', function ()
    {
        return view('admin.index');
    })->name('dashboard');
});
