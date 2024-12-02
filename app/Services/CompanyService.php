<?php

namespace App\Services;


use App\Models\Company;

class CompanyService
{

    /**
     * @throws \Throwable
     */
    public function store($name)
    {
        $company = new Company();
        $company->name = $name;
        $company->saveOrFail();
    }
}
