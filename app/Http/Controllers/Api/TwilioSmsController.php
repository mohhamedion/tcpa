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
    public function receiveMessage(Request $request, $hash): MessagingResponse
    {

        try {
            /** @var Company $company */
            $company = Company::query()->where('hash', $hash)->firstOrFail();

            $messageContent = $request->input('Body');
            $fromNumber = $request->input('From');

            /** @var Client $client */
            $client = Client::query()->waitingClientAgreement()->where('company_id', $company->id)->where('phone_number', $fromNumber)->firstOrFail();
            Log::info("Incoming SMS message from $fromNumber, content: {$messageContent}", ['client_id' => $client->id]);

            if ($messageContent === "YES") {
                $this->clientService->clientAcceptTcpa($client);
            } else if ($messageContent === "NO") {
                $this->clientService->clientDeclineTcpa($client);
            } else {
                //todo: handle other type of messages
                Log::info(json_encode($request->all()));
            }
        } catch (Throwable $exception) {
            Log::error("Error while reading message: " . $exception->getMessage(), ['client_id' => $client->id]);
            Log::info("Request body : " . json_encode($request->all()), ['client_id' => $client->id]);
        }

        return new MessagingResponse();
    }

}
