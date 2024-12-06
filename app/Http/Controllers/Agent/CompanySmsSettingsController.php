<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\TwilioSettings\CreateOrUpdateCompanyTwilioSettings;
use App\Models\User;
use App\Services\CompanyTwilioSettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class CompanySmsSettingsController extends Controller
{
    private CompanyTwilioSettingsService $companySmsSettingsService;

    public function __construct(CompanyTwilioSettingsService $companySmsSettingsService)
    {
        $this->companySmsSettingsService = $companySmsSettingsService;
    }

    public function twilioSettings(Request $request)
    {
        $user = $request->user();
        return view('agent.twilio-settings.index')->with(['companyTwilioSettings' => $user->company->companyTwilioSettings]);
    }
    /**
     * @throws Throwable
     */
    public function createOrUpdate(CreateOrUpdateCompanyTwilioSettings $request)
    {
        try {
            /**
             * @var User $user ;
             */
            $user = $request->user();
            $phoneNumber = $request->input('phone_number');
            $sid = $request->input('sid');
            $token = $request->input('token');
            $this->companySmsSettingsService->createOrUpdate($user->company, $phoneNumber, $sid, $token);
            session()->flash('success','Twilio settings updated');

        } catch (Throwable $exception) {
            Log::error("Error while saving twilio settings ".$exception->getMessage());
            session()->flash('error','Error while saving twilio settings');
        }

        return redirect()->back();

    }

}
