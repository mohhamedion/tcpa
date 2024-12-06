@extends('agent.layers.layout')
@section('content')

    <section class="container">
        <div class="alert alert-info">
            <p>Hi {{\Illuminate\Support\Facades\Auth::user()->name}}, before getting started, please make sure to enter your company's Twilio credentials in the service form.</p>
            <a class="nav-item nav-link" href="{{route('twilio-settings.index',['company_hash' => request()->attributes->get('company_hash')])}}">Twilio settings</a>
        </div>
    </section>

@endsection
