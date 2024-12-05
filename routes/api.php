<?php

use App\Http\Controllers\Api\TwilioSmsController;
use Illuminate\Support\Facades\Route;

Route::post('/{company}/sms/twilio/receive-message', [TwilioSmsController::class,'receiveMessage'])->name('twilio.webhook');
