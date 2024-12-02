<?php

namespace App\Console\Commands;

use App\Services\TwilioService;
use Illuminate\Console\Command;

class TestPhoneNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-phone-number';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $smsService = new TwilioService();

        $smsService->sendSmsMessage();
        //
    }
}
