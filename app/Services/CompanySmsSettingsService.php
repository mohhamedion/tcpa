<?php

namespace App\Services;


use App\Models\Company;
use App\Models\CompanySmsSettings;


class CompanySmsSettingsService
{

    /**
     * @throws \Throwable
     */
    public function store( string $phoneNumber, Company $company)
    {
        $companySettings = new CompanySmsSettings();
        $companySettings->from_number = $phoneNumber;
        $companySettings->company_id = $company->id;
        $companySettings->saveOrFail();

    }


    /**
     * @throws \Throwable
     */
    public function update(CompanySmsSettings $companySmsSettings, string $phoneNumber)
    {
        $companySmsSettings->from_number = $phoneNumber;
        $companySmsSettings->saveOrFail();
    }


}
