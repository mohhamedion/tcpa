<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
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

    public function show(Client $client)
    {
        return view('agent.clients.show')->with(['client' => $client]);
    }

    /**
     * @throws Throwable
     */
    public function store(Request $request)
    {
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
                session()->flash('error', "Error while sending verification code");
            }

            return redirect()->to(route('clients.show', ['client' => $client->id]));

        } catch (Throwable $exception) {
            Log::error("Error while creating client: " . $exception->getMessage());
            session()->flash('error', "Error while creating client");
        }

        return redirect()->back();

    }

    /**
     * @throws Throwable
     */
    public function verify(Request $request, Client $client)
    {
        $this->clientService->verify($client, $request->input('verification_code'));
        return redirect()->back();
    }

}
