<?php

namespace App\Services;

use App\Enums\Client\Statuses;
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
        $client->status = Statuses::CREATED->value; //todo move to enum
        $client->saveOrFail();
        return $client;
    }

    /**
     * @throws Throwable
     */
    public function sendVerificationCode(Client $client)
    {
        if($client->status !== Statuses::CREATED->value){
            throw new Exception('Client was already verified');
        }
        $verificationCode = substr(str_shuffle("0123456789"), 0, 4);
        //todo get content template by company
        $template = "Your verification code is {$verificationCode}. Please provide it to the agent to begin the consent process.";
        $this->smsMessageService->store(
            $client->company->companyTwilioSettings->from_number,
            $client->phone_number ,
            $template
        );

        $client->verification_code = $verificationCode;
        $client->status = Statuses::WAITING_FOR_VERIFICATION->value;
        $client->saveOrFail();
    }

    /**
     * @throws Throwable
     */
    public function sendRequestToAcceptTCPA(Client $client)
    {
        //todo get content template by company
        $template = "Consent Request for John Smith at '{$client->phone_number}'.
Please reply 'YES' to confirm that you consent to receive advertisement calls from {$client->company->name}. ";
        $this->smsMessageService->store(
            $client->company->companyTwilioSettings->from_number,
            $client->phone_number ,
            $template
        );

        $client->status = Statuses::WAITING_FOR_CLIENT_AGREEMENT->value;
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
        if($client->verification_code != $verificationCode)
        {
            throw new Exception("Verification code incorrect"); // todo: create unique exception
        }

        $client->status = Statuses::NUMBER_VERIFIED->value;
        $client->saveOrFail();
    }

    /**
     * @throws Throwable
     */
    public function clientAcceptTcpa(Client $client)
    {
        $client->status = Statuses::TCPA_ACCEPTED->value;
        $client->saveOrFail();
    }

    /**
     * @throws Throwable
     */
    public function clientDeclineTcpa(Client $client)
    {
        $client->status = Statuses::TCPA_DECLINED->value;
        $client->saveOrFail();
    }


}
