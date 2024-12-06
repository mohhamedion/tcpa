@extends('agent.layers.layout')
@section('content')

    <section class="container">

        <div class="alert alert-info">
            Use dynamic fields like [company_name] or [code]. The system will replace them with actual data in the SMS message.
        </div>
        @foreach(\App\Enums\SmsContentTemplate\AvailableLanguages::cases() as $language)
            <form
                class="mt-1"
                action="{{route('sms-content-template.create-or-update',['company_hash' =>  request()->attributes->get('company_hash')])}}"
                method="post"
            >
                @csrf
                @method('POST')
                @php
                    /**
                     * @var $smsTemplates
                     * @var $language
                     */

                        $verificationCodeTemplate = $smsTemplates->where('language',$language->value)->where('type','verification_code_template')->first();
                        $TcpaAgrementTemplate = $smsTemplates->where('language',$language->value)->where('type','tcpa_template')->first();

                @endphp

            <div class="card mb-2">

                <div class="card-body">
                    <p>Language: {{$language->label()}}</p>
                    <div class="mt-1">
                        <label  >Verification code template</label>
                        <textarea class="form-control" rows="5" name="languages[{{$language->value}}][verification_code_template]">{{$verificationCodeTemplate?->template}}</textarea>
                    </div>

                    <div class="mt-1">
                        <label  >TCPA template</label>
                        <textarea class="form-control" name="languages[{{$language->value}}][tcpa_template]" rows="5">{{$TcpaAgrementTemplate?->template}}</textarea>
                    </div>
                </div>
            </div>
                <button class="btn btn-info">Save</button>
        </form>
        @endforeach



    </section>

@endsection
