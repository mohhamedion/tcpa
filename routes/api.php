<?php

use Illuminate\Support\Facades\Route;

Route::post('/sms/twilio/receive-message', [\App\Http\Controllers\Api\TwilioSmsController::class,'receiveMessage']);
