<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use Throwable;


class ClientService
{
    /**
     * @throws Throwable
     */
    public function store(Company $company, User $user, string $firstName, string $lastName, string $phoneNumber, string $language)
    {
        $client = new Client();
        $client->company_id = $company->id;
        $client->first_name = $firstName;
        $client->last_name = $lastName;
        $client->phone_number = $phoneNumber;
        $client->agent_id = $user->id;
        $client->language = $language;
        //todo send sms
        $client->status = 'waiting_for_verification'; //todo move to enum
        $client->verification_code = 1111; // hashcode
        $client->saveOrFail();
        return $client;

    }

    /**
     * @param $client
     * @param $verificationCode
     * @return void
     * @throws Throwable
     */
    public function verify(Client $client, $verificationCode)
    {
        if($client->verification_code === $verificationCode){
            $client->status = 'waiting_for_client_agreement';
        }
        //todo send sms
        $client->saveOrFail();

    }


    /**
     * @param $client
     * @return void
     */
    public function clientAcceptTCPA(Client $client)
    {
        $client->status = 'client_accept_tcpa';
        $client->saveOrFail();
    }

}
