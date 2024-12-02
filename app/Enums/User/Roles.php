<?php

namespace App\Enums\User;

enum Roles: string
{
    case Admin = 'admin';
    case Agent = 'agent';
}
