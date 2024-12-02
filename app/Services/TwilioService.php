<?php

namespace App\Services;

use Exception;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;


class TwilioService
{

    public $client;

    /**
     * @throws ConfigurationException
     */
    public function __construct()
    {
        $sid = env('sid');
        $token = env('token');
        $this->client = new Client($sid, $token);
    }


    public function sendSmsMessage()
    {
        //+17752599230
            $from = "+15005550006"; // Twilio Test 'From' number (simulates success)
            $to = "+15005550009";   // Simulated success 'To' number

            // Send a test message
            $message = $this->client->messages->create(
                $to,
                [
                    'from' => $from,
                    'body' => 'This is a test message using Twilio Test Credentials.'
                ]
            );

            // Output the Message SID
            echo "Test message sent successfully! Message SID: " . $message->sid . "\n";


    }


}
