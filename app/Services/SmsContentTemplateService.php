<?php

namespace App\Services;

use App\Enums\SmsContentTemplate\AvailableTypes;
use App\Models\Client;
use App\Models\Company;
use App\Models\SmsContentTemplate;
use Throwable;

class SmsContentTemplateService
{
    /**
     * @throws Throwable
     */
    public function createOrUpdate(Company $company, string $language, string $contentTemplate, string $type)
    {
        $template = $company->smsContentTemplate()
            ->where('language', $language)
            ->where('type', $type)
            ->first();

        if (!$template) {
            $template = new SmsContentTemplate();
            $template->company_id = $company->id;
        }

        $template->template = $contentTemplate;
        $template->language = $language;
        $template->type = $type;

        $template->save();
    }


    public function getParsedTemplate(Client $client,$type , array $customFields)
    {
        $client->loadMissing('company.smsContentTemplate');

        $template = $client->company->smsContentTemplate->where('type' , $type)->where('language', $client->language)->first();

        $message = $template->template;

        foreach ($customFields as $customField => $value) {
            $message = str_replace("[$customField]", $value, $message);
        }

        return $message;
    }

}
