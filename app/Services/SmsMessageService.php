<?php

namespace App\Services;


use App\Models\SmsMessage;
use Illuminate\Support\Facades\Log;
use Throwable;

class SmsMessageService
{

    public TwilioService $smsService;

    public function __construct(TwilioService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * @throws Throwable
     */
    public function store(string $from, string $to, string $content): SmsMessage
    {

        $smsMessage = new SmsMessage();
        $smsMessage->from_number = $from;
        $smsMessage->to_number = $to;
        $smsMessage->content = $content;
        $smsMessage->sms_service = $this->smsService::class;

        try {
            $this->smsService->sendSmsMessage($from, $to, $content);
            $smsMessage->status = 'success';
        }catch (Throwable $exception){
            $smsMessage->status = 'failed';
            Log::info("Error while sending sms message from {$from} to {$to}. Using {$this->smsService::class} service : ". $exception->getMessage());
        }

        $smsMessage->saveOrFail();

        return $smsMessage;

    }

}
