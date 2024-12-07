<?php

namespace App\Services;


use App\Models\Company;
use App\Models\CompanyTwilioSettings;

class CompanyTwilioSettingsService
{
    /**
     * @throws \Throwable
     */
    public function createOrUpdate(Company $company, string $phoneNumber, string $sid, string $token): void
    {
        $companyTwilioSettings = $company->companyTwilioSettings()->first();
        if (!$companyTwilioSettings) {
            $companyTwilioSettings = new CompanyTwilioSettings();
        }
        $companyTwilioSettings->from_number = $phoneNumber;
        $companyTwilioSettings->sid = $sid;
        $companyTwilioSettings->token = $token;
        $companyTwilioSettings->company_id = $company->id;
        $companyTwilioSettings->saveOrFail();
    }


}
