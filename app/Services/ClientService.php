<?php

namespace App\Services;

use App\Enums\Client\Statuses;
use App\Enums\SmsContentTemplate\AvailableTypes;
use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;


class ClientService
{

    public SmsMessageService $smsMessageService;
    public SmsContentTemplateService $smsContentTemplateService;

    public function __construct(SmsMessageService $smsMessageService, SmsContentTemplateService $smsContentTemplateService)
    {
        $this->smsMessageService = $smsMessageService;
        $this->smsContentTemplateService = $smsContentTemplateService;
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
        $client->status = Statuses::CREATED->value;
        $client->saveOrFail();

        Log::info("New client {$client->first_name} {$client->last_name} created", ['client_id' => $client->id]);

        return $client;
    }

    /**
     * @throws Throwable
     */
    public function sendVerificationCode(Client $client): void
    {
        if ($client->status == Statuses::NUMBER_VERIFIED->value) {
            throw new Exception('Client was already verified');
        }


        $verificationCode = substr(str_shuffle("0123456789"), 0, 4);


        try {
            DB::beginTransaction();
            $client->verification_code = $verificationCode;
            $client->status = Statuses::WAITING_FOR_VERIFICATION->value;
            $client->saveOrFail();

            try {

                $template = $this->smsContentTemplateService->getParsedTemplate($client, AvailableTypes::VerificationCode->value,
                    [
                        'company_name' => $client->company->name,
                        'code' => $verificationCode,
                        'client_name' => $client->first_name . " " . $client->last_name,
                        'to_phone_number' => $client->phone_number,
                    ]
                );
            } catch (Throwable $exception) {
                Log::error("Error while getting template, switching to default template. Error: " . $exception->getMessage(), ['client_id' => $client->id]);
                $template = "Your verification code is {$verificationCode}. Please provide it to the agent to begin the consent process.";
            }
            $this->smsMessageService->sendSmsMessage($client->company,
                $client->company->companyTwilioSettings->from_number,
                $client->phone_number,
                $template
            );

            Log::info("sending verification code to client {$client->first_name} {$client->last_name}", ['client_id' => $client->id]);

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }


    }

    /**
     * @throws Throwable
     */
    public function sendRequestToAcceptTCPA(Client $client): void
    {
        try {
            $template = $this->smsContentTemplateService->getParsedTemplate($client, AvailableTypes::TcpaAgreement->value,
                [
                    'company_name' => $client->company->name,
                    'client_name' => $client->first_name . " " . $client->last_name,
                    'to_phone_number' => $client->phone_number,

                ]
            );

        } catch (Throwable $exception) {
            Log::error("Error while getting template, switching to default template. Error: " . $exception->getMessage());
            $template = "Consent Request for John Smith at '{$client->phone_number}'.
Please reply 'YES' to confirm that you consent to receive advertisement calls from {$client->company->name}. ";
        }

        $this->smsMessageService->sendSmsMessage($client->company,
            $client->company->companyTwilioSettings->from_number,
            $client->phone_number,
            $template
        );

        $client->status = Statuses::WAITING_FOR_CLIENT_AGREEMENT->value;
        $client->saveOrFail();

        Log::info("sending sms to  {$client->first_name} {$client->last_name} ", ['client_id' => $client->id]);

    }

    /**
     * @param Client $client
     * @param $verificationCode
     * @return void
     * @throws Throwable
     */
    public function verify(Client $client, $verificationCode): void
    {
        if ($client->verification_code != $verificationCode) {
            throw new Exception("Verification code incorrect"); // todo: create unique exception
        }

        $client->status = Statuses::NUMBER_VERIFIED->value;
        $client->saveOrFail();
    }

    /**
     * @throws Throwable
     */
    public function clientAcceptTcpa(Client $client): void
    {
        $client->status = Statuses::TCPA_ACCEPTED->value;
        $client->saveOrFail();
    }

    /**
     * @throws Throwable
     */
    public function clientDeclineTcpa(Client $client): void
    {
        $client->status = Statuses::TCPA_DECLINED->value;
        $client->saveOrFail();
    }


    /**
     * @throws Throwable
     */
    public function delete(Client $client): void
    {
        $client->deleteOrFail();
    }

    public function index(User $user = null, int $page = 1, string $status = null, string $date = null, string $phoneNumber = null): LengthAwarePaginator
    {
        $query = Client::query();

        if ($status) {
            $query->where('status', $status);
        }
        if ($date) {
            $query->whereDate('created_at', $date);
        }
        if ($phoneNumber) {
            $query->where('phone_number', 'like', '%' . $phoneNumber . '%');
        }

        if ($user) {
            $query->where('agent_id', $user->id);
        }

        return $query->forPage($page)->paginate(10);

    }


}
