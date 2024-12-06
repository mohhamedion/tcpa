<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\VerifySmsCodeRequest;
use App\Models\Client;
use App\Models\User;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class ClientController extends Controller
{
    private ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }


    public function index(Request $request)
    {
        $clients = Client::query()->where('agent_id', $request->user()->id)->get();
        return view('agent.clients.index')->with(['clients' => $clients]);
    }

    public function createForm()
    {

        return view('agent.clients.create');
    }

    public function updateForm()
    {

        return view('agent.clients.update');
    }

    public function show($companyHash, Client $client)
    {
        return view('agent.clients.show')->with(['client' => $client, 'company_hash' => $companyHash]);
    }

    /**
     * @throws Throwable
     */
    public function store(StoreClientRequest $request)
    {
        // todo: add policy

        /**
         * @var User $user
         */
        $user = $request->user();

        try {
            $client = $this->clientService->store(
                $user->company
                , $user
                , $request->input('first_name')
                , $request->input('last_name')
                , $request->input('phone_number')
                , $request->input('language')
            );

            try {
                $this->clientService->sendVerificationCode($client);
            } catch (Throwable $exception) {
                Log::error("Error while sending verification code: " . $exception->getMessage());
                session()->flash('error', "Error while sending verification code: ".$exception->getMessage());
            }

            return redirect()->to(route('clients.show', ['client' => $client->id,'company_hash' => $user->company->hash]));

        } catch (Throwable $exception) {
            Log::error("Error while creating client: " . $exception->getMessage());
            session()->flash('error', "Error while creating client");
        }

        return redirect()->back();

    }

    public function sendVerificationCode(Request $request, string $companyHash, Client $client)
    {

        // todo: add policy

        try {
            $this->clientService->sendVerificationCode($client);
        } catch (Throwable $exception) {
            Log::error("Error while sending verification code: " . $exception->getMessage());
            session()->flash('error', "Error while sending verification code: ".$exception->getMessage());
        }

        return redirect()->back();

    }
    /**
     * @throws Throwable
     */
    public function verify(VerifySmsCodeRequest $request,string $companyHash, Client $client)
    {
        // todo: add policy

        try {
            $this->clientService->verify($client, $request->input('verification_code'));

            try {
                $this->clientService->sendRequestToAcceptTCPA($client);
            } catch (Throwable $exception) {
                session()->flash('error', "Error while sending sms to accept TCPA");
            }

        } catch (Throwable $exception) {
            session()->flash('error', "Error while verifying verification code: ". $exception->getMessage());
        }

        return redirect()->back();
    }

}
