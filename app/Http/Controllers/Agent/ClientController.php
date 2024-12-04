<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Throwable;

class ClientController extends Controller
{
    private ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }


    public function index()
    {

        return view('agent.clients.index');
    }

    public function createForm()
    {

        return view('agent.clients.create');
    }

    public function updateForm()
    {

        return view('agent.clients.update');
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
        $client = $this->clientService->store(
            $user->company
            , $user
            , $request->input('first_name')
            , $request->input('last_name')
            , $request->input('phone_number')
            , $request->input('language')
        );

        return redirect()->to(route('clients.show', ['client' => $client->id]));
    }


}
