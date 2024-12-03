<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Throwable;

class CompanyController extends Controller
{
    private CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index()
    {
        $companies = $this->companyService->index();
        return view('admin.companies.index')->with(['companies' => $companies]);
    }

    /**
     * @throws Throwable
     */
    public function createForm(Request $request)
    {
        return view('admin.companies.create');
    }

    /**
     * @throws Throwable
     */
    public function store(Request $request)
    {
        try {
            $this->companyService->store($request->input('name'));
        } catch (Throwable $exception) {
        }

        return redirect()->to(route('companies.index'));
    }


    /**
     * @throws Throwable
     */
    public function updateForm(Company $company)
    {
        return view('admin.companies.update')->with(['company' => $company]);
    }

    /**
     * @throws Throwable
     */
    public function update(Company $company, Request $request)
    {
        try {
            $this->companyService->update($company, $request->input('name'));
        } catch (Throwable $exception) {
        }

        return redirect()->to(route('companies.index'));
    }

    /**
     * @throws Throwable
     */
    public function delete(Company $company)
    {
        try {
            $this->companyService->delete($company);
        } catch (Throwable $exception) {
        }

        return redirect()->to(route('companies.index'));
    }


}
