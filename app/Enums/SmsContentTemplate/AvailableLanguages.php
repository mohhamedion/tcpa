<?php

namespace App\Enums\SmsContentTemplate;

enum AvailableLanguages: string
{
    case English = 'english';
    case Russian = 'russian';

    public function label(): string
    {
        return match ($this) {
            self::English => 'English',
            self::Russian => 'Русский',
        };
    }
}
