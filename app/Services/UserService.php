<?php

namespace App\Services;

use App\Enums\User\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserService
{

    /**
     * @throws Throwable
     */
    public function store(string $name, string $login, string $password, Roles $role)
    {
        $user = new User();
        $user->name = $name;
        $user->login = $login;
        $user->password = Hash::make($password);
        $user->assignRole($role->value);
        $user->saveOrFail();
    }


}
