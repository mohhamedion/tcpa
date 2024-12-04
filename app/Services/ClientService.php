<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use Exception;
use Throwable;


class ClientService
{

    public SmsMessageService $smsMessageService;

    public function __construct(SmsMessageService $smsMessageService)
    {
        $this->smsMessageService = $smsMessageService;
    }

    /**
     * @throws Throwable
     */
    public function store(Company $company, User $user, string $firstName, string $lastName, string $phoneNumber, string $language): Client
    {

        $client = new Client();
        $client->company_id = $company->id;
        $client->first_name = $firstName;
        $client->last_name = $lastName;
        $client->phone_number = $phoneNumber;
        $client->agent_id = $user->id;
        $client->language = $language;
        $client->status = 'created'; //todo move to enum
        $client->saveOrFail();

        return $client;

    }

    /**
     * @throws Throwable
     */
    public function sendVerificationCode(Client $client)
    {
        $verificationCode = substr(str_shuffle("0123456789"), 0, 4);
        $this->smsMessageService->store(
            $client->company->smsSettings->from_number,
            $client->phone_number ,
            $verificationCode
        );


        //todo get content template by company
        $client->verification_code = $verificationCode;
        $client->status = 'waiting_for_verification';
        $client->saveOrFail();
    }


    /**
     * @param Client $client
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
