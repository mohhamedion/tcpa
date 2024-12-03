<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\CompanySmsSettings;
use App\Services\CompanySmsSettingsService;
use Illuminate\Http\Request;
use Throwable;

class ClientController extends Controller
{
    private CompanySmsSettingsService $companySmsSettingsService;

    public function __construct(CompanySmsSettingsService $companySmsSettingsService)
    {
        $this->companySmsSettingsService = $companySmsSettingsService;
    }


    public function index(){

        return view('agent.clients.index');
    }
    /**
     * @throws Throwable
     */
    public function createForm(Request $request, CompanySmsSettings $companySmsSettings)
    {
        try {
            $this->companySmsSettingsService->update($companySmsSettings, $request->input('phone_number'));
        } catch (Throwable $exception) {
        }

    }

    /**
     * @throws Throwable
     */
    public function update(Request $request, CompanySmsSettings $companySmsSettings)
    {
        try {
            $this->companySmsSettingsService->update($companySmsSettings, $request->input('phone_number'));
        } catch (Throwable $exception) {
        }

    }

}
