<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Agent\ClientController;
use App\Http\Controllers\Agent\CompanySmsSettingsController;
use App\Http\Controllers\Agent\SmsTemplateController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\SetCompanyHashPrefix;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdminMiddleware;


Route::group([],function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth:web', IsAdminMiddleware::class])->group(function()
{
    Route::get('/', function () {
        return view('admin.index');
    })->name('admin.dashboard');

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


Route::middleware(['auth:web'])->middleware(SetCompanyHashPrefix::class)->prefix('{company_hash}')->group(function()
{
    Route::get('/', function () {
        return view('agent.index');
    })->name('agent.dashboard');

    Route::group(['prefix' => 'clients'],function() {
        Route::get('/',[ClientController::class,'index'])->name('clients.index');
        Route::get('/create',[ClientController::class,'createForm'])->name('clients.createForm');
        Route::get('/{client}',[ClientController::class,'show'])->name('clients.show');
        Route::get('/sent-verification-code/{client}',[ClientController::class,'sendVerificationCode'])->name('clients.send-verification-code');

        Route::post('/verify/{client}',[ClientController::class,'verify'])->name('clients.verify');
        Route::post('/',[ClientController::class,'store'])->name('clients.store');

        Route::delete('/{client}',[ClientController::class,'delete'])->name('clients.delete');


    });

    Route::group(['prefix' => 'sms-content-template'],function() {
        Route::get('/',[SmsTemplateController::class,'index'])->name('sms-content-template.index');
        Route::post('/create-or-update',[SmsTemplateController::class,'createOrUpdate'])->name('sms-content-template.create-or-update');
    });

    Route::group(['prefix' => 'twilio-settings'],function() {
        Route::get('/',[CompanySmsSettingsController::class,'twilioSettings'])->name('twilio-settings.index');
        Route::post('/update',[CompanySmsSettingsController::class, 'createOrUpdate'])->name('twilio-settings.update');
    });
});
