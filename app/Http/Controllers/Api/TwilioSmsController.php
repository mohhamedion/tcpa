<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Company;
use App\Services\ClientService;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;
use Twilio\TwiML\MessagingResponse;

class TwilioSmsController extends Controller
{
    public TwilioService $twilioService;
    public ClientService $clientService;

    public function __construct(TwilioService $twilioService, ClientService $clientService)
    {
        $this->twilioService = $twilioService;
        $this->clientService = $clientService;
    }

    /**
     * @throws Throwable
     */
    public function receiveMessage(Request $request, Company $company)
    {
        Log::info(json_encode($request->all()));

        $messageContent = $request->input('Body');
        $fromNumber = $request->input('From');

        $client = Client::query()->waitingClientAgreement()->where('company_id',$company->id)->where('phone_number',$fromNumber)->firstOrFail();

        if($messageContent === "YES"){
            $this->clientService->clientAcceptTcpa($client);
        }else if( $messageContent === "NO")
        {
            $this->clientService->clientDeclineTcpa($client);
        }else{
            // other type of messages
        }

        return new MessagingResponse();
    }

}
