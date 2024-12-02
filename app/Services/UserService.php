<?php

namespace App\Services;

use App\Enums\User\Roles;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserService
{

    /**
     * @throws Throwable
     */
    public function store(string $name, string $login, string $password, Roles $role, Company $company = null)
    {
        $user = new User();
        $user->name = $name;
        $user->login = $login;
        $user->password = Hash::make($password);
        $user->assignRole($role->value);

        if($company)
        {
            $user->company_id = $company->id;
        }

        $user->saveOrFail();
    }


}
