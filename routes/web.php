<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});

Route::middleware('auth:web')->group(function()
{
    Route::get('/', function () {
        return view('admin.index');
    })->name('dashboard');

    Route::group(['prefix' => 'companies'],function() {
        Route::get('/',[CompanyController::class,'index'])->name('companies.index');
        Route::get('/create',[CompanyController::class, 'createForm'])->name('companies.createForm');
        Route::get('/update/{company}',[CompanyController::class,'updateForm'])->name('companies.updateForm');
        Route::post('/store',[CompanyController::class,'store'])->name('companies.store');
        Route::post('/update/{company}',[CompanyController::class,'update'])->name('companies.update');
        Route::delete('/{company}',[CompanyController::class,'delete'])->name('companies.delete');
    });
});
