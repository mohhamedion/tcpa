<?php

namespace App\Services;

use Exception;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;


class TwilioService
{

    private Client $client;

    /**
     * @throws ConfigurationException
     */
    public function __construct($sid, $token)
    {
        $this->client = new Client($sid, $token);
    }


    /**
     * @throws TwilioException
     */
    public function sendSmsMessage($from, $to, $content): void
    {
        // create smsMessage
        $this->client->messages->create(
            $to,
            [
                'from' => $from,
                'body' => $content
            ]
        );

    }


}
