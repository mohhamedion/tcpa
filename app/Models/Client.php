<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
