<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsMessageService;
use Illuminate\Http\Request;


class SmsMessagesController extends Controller
{
    public SmsMessageService $templateService;

    public function __construct(SmsMessageService $templateService)
    {
        $this->templateService = $templateService;
    }


    public function index(Request $request)
    {
        /**
         * @var User $user ;
         */
        $user = $request->user();

        return view('agent.sms-messages.index')->with(['smsMessages' => $user->company->smsMessages]);
    }

}
