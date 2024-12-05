<?php

namespace App\Models;

use App\Enums\Client\Statuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * @property int $id;
 * @property string $first_name;
 * @property string $last_name;
 * @property string $language;
 * @property string $status;
 * @property string $phone_number;
 * @property string $verification_code;
 * @property int $agent_id;
 * @property int $company_id;
 * @property Company $company;
 */
class Client extends Model
{
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function ScopeWaitingClientAgreement($query)
    {
        return $query->where('status',Statuses::WAITING_FOR_CLIENT_AGREEMENT->value);
    }
}
