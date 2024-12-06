<?php

namespace App\Http\Controllers\Agent;

use App\Enums\SmsContentTemplate\AvailableTypes;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsContentTemplateService;
use Illuminate\Http\Request;
use Throwable;


class SmsTemplateController extends Controller
{
    public SmsContentTemplateService $templateService;

    public function __construct(SmsContentTemplateService $templateService)
    {
        $this->templateService = $templateService;
    }


    public function index(Request $request)
    {
        /**
         * @var User $user ;
         */
        $user = $request->user();

        return view('agent.sms-templates.index')->with(['smsTemplates' => $user->company->smsContentTemplate]);
    }
    /**
     * @throws Throwable
     */
    public function createOrUpdate(Request $request)
    {
        /**
         * @var User $user;
         */
        $user = $request->user();

        foreach ($request->input('languages') as $language => $languageTemplate )
        {
            $this->templateService->createOrUpdate($user->company,
                $language,
                $languageTemplate['verification_code_template'],
                AvailableTypes::VerificationCode->value);

            $this->templateService->createOrUpdate($user->company,
                $language,
                $languageTemplate['tcpa_template'],
                AvailableTypes::TcpaAgreement->value);
        }



        return redirect()->back();
    }
}
