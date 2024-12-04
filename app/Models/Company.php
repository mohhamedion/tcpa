<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * @property int $id
 * @property string $name;
 * @property companySmsSettings smsSettings;
 */
class Company extends Model
{
    public function smsSettings(): HasOne
    {
        return $this->hasOne(CompanySmsSettings::class,'company_id','id');
    }

}
