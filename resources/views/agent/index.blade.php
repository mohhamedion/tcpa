@extends('agent.layers.layout')
@section('content')

    <section class="container">
        <div>
            <p>Hi Agent, before starting, please ensure to fill your company twilio credentials in service form</p>
            <a class="nav-item nav-link" href="{{route('twilio-settings.index',['company_hash' => request()->attributes->get('company_hash')])}}">Twilio settings</a>
        </div>
    </section>

@endsection
