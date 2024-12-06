<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class CompanyService
{

    /**
     * @throws Throwable
     */
    public function store(string $name): void
    {
        $company = new Company();
        $company->name = $name;
        $company->saveOrFail();
    }

    /**
     * @throws Throwable
     */
    public function update(Company $company, string $name): void
    {
        $company->name = $name;
        $company->saveOrFail();
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Company::all();
    }

    /**
     * @throws Throwable
     */
    public function delete(Company $company): void
    {
        $company->deleteOrFail();
    }

}
