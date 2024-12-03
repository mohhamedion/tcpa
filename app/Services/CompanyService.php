<?php

namespace App\Services;

use App\Models\Company;
use Throwable;

class CompanyService
{

    /**
     * @throws Throwable
     */
    public function store(string $name)
    {
        $company = new Company();
        $company->name = $name;
        $company->saveOrFail();
    }

    /**
     * @throws Throwable
     */
    public function update(Company $company, string $name)
    {
        $company->name = $name;
        $company->saveOrFail();
    }


    public function index()
    {
        return Company::all();
    }

    /**
     * @throws Throwable
     */
    public function delete(Company $company)
    {
        $company->deleteOrFail();
    }

}
