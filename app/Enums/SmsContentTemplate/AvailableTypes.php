<?php

namespace App\Enums\SmsContentTemplate;

enum AvailableTypes: string
{
    case VerificationCode = 'verification_code_template';
    case TcpaAgreement = 'tcpa_template';

    public function label(): string
    {
        return match ($this) {
            self::VerificationCode => 'Verification Code',
            self::TcpaAgreement => 'TCPA Agreement',
        };
    }
}
