<?php

namespace App\Services;


use App\Models\Company;
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
    public function sendSmsMessage(Company $company, string $from, string $to, string $content): SmsMessage
    {

        try {
            $this->smsService->sendSmsMessage($from, $to, $content);
            $smsMessage = new SmsMessage();
            $smsMessage->from_number = $from;
            $smsMessage->to_number = $to;
            $smsMessage->content = $content;
            $smsMessage->sms_service = $this->smsService::class;
            $smsMessage->status = 'success';
            $smsMessage->company_id = $company->id;
            $smsMessage->saveOrFail();
        } catch (Throwable $exception) {
            Log::info("Error while sending sms message from {$from} to {$to}. : " . $exception->getMessage());
            throw $exception;
        }

        return $smsMessage;

    }

}
