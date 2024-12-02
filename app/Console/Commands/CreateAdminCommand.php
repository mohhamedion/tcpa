<?php

namespace App\Console\Commands;

use App\Enums\User\Roles;
use App\Services\UserService;
use Illuminate\Console\Command;
use Throwable;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin {name} {login} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Create Admin';

    /**
     * Execute the console command.
     * @throws Throwable
     */
    public function handle()
    {
        $userService = new UserService();

        try {
            $userService->store($this->argument('name'),$this->argument('login'),$this->argument('password'),Roles::Admin);
            $this->info("User created");
        }catch (Throwable $exception){
            $this->error($exception->getMessage());
        }

    }
}
