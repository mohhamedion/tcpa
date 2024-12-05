<?php

namespace App\Enums\Client;

enum Statuses: string
{
    case CREATED = 'created';
    case WAITING_FOR_VERIFICATION = 'waiting_for_verification';
    case NUMBER_VERIFIED = 'number_verified';
    case WAITING_FOR_CLIENT_AGREEMENT = 'waiting_for_client_agreement';
    case TCPA_ACCEPTED = 'tcpa_accepted';
    case TCPA_DECLINED = 'tcpa_declined';
}
