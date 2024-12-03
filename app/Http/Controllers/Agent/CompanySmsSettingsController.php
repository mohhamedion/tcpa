<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\CompanySmsSettings;
use App\Services\CompanySmsSettingsService;
use Illuminate\Http\Request;
use Throwable;

class CompanySmsSettingsController extends Controller
{
    private CompanySmsSettingsService $companySmsSettingsService;

    public function __construct(CompanySmsSettingsService $companySmsSettingsService)
    {
        $this->companySmsSettingsService = $companySmsSettingsService;
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
