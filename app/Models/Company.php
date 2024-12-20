<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;


/**
 * @property int $id
 * @property string $name;
 * @property string $hash;
 * @property CompanyTwilioSettings $companyTwilioSettings;
 * @property SmsContentTemplate[]|Collection $smsContentTemplate;
 * @property SmsMessage[]|Collection $smsMessages;
 */
class Company extends Model
{
    /**
     * @return HasOne
     */
    public function companyTwilioSettings(): HasOne
    {
        return $this->hasOne(CompanyTwilioSettings::class, 'company_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function smsContentTemplate(): HasMany
    {
        return $this->hasMany(SmsContentTemplate::class, 'company_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function smsMessages(): HasMany
    {
        return $this->hasMany(SmsMessage::class, 'company_id', 'id');
    }


    /**
     * Event listener for model creation
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->hash) {
                $model->hash = (string)Str::uuid();
            }
        });
    }

}
