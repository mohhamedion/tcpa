<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * @property int $id
 * @property string $name;
 * @property CompanyTwilioSettings $companyTwilioSettings;
 */
class Company extends Model
{
    public function companyTwilioSettings(): HasOne
    {
        return $this->hasOne(CompanyTwilioSettings::class,'company_id','id');
    }

}
