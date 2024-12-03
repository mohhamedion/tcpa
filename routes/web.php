<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdminMiddleware;


Route::prefix('admin')->group(function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});

Route::middleware(['auth:web', IsAdminMiddleware::class])->group(function()
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

    Route::group(['prefix' => 'agents'],function() {
        Route::get('/{company}',[UserController::class,'index'])->name('agents.index');
        Route::get('/create/{company}',[UserController::class, 'createForm'])->name('agents.createForm');
        Route::get('/update/{company}/{user}',[UserController::class,'updateForm'])->name('agents.updateForm');
        Route::post('/store/{company}',[UserController::class,'store'])->name('agents.store');
        Route::put('/update/{company}/{user}',[UserController::class,'update'])->name('agents.update');
        Route::delete('/{user}',[UserController::class,'delete'])->name('agents.delete');
    });

});
