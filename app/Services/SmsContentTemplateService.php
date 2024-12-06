<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Company;
use App\Models\SmsContentTemplate;
use Throwable;

class SmsContentTemplateService
{
    /**
     * @throws Throwable
     */
    public function createOrUpdate(Company $company, string $language, string $contentTemplate, string $type): void
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


    public function getParsedTemplate(Client $client, string $type, array $customFields): string
    {
        $client->loadMissing('company.smsContentTemplate');

        $template = $client->company->smsContentTemplate->where('type', $type)->where('language', $client->language)->first();

        $message = $template->template;

        foreach ($customFields as $customField => $value) {
            $message = str_replace("[$customField]", $value, $message);
        }

        return $message;
    }

}
