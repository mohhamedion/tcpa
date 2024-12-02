<?php

namespace App\Console\Commands;

use App\Enums\User\Roles;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InitAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-app';

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
        Role::findOrCreate(Roles::Admin->value);
        Role::findOrCreate(Roles::Agent->value);
    }
}
