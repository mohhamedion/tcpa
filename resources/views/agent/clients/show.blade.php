@extends('agent.layers.layout')
@section('content')

    <section class="container">
        <div class="container mt-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Client Information</h5>
                </div>
                <div class="card-body">
                    <b class="card-title">Name:</b>
                    <p class="card-text" id="clientName">{{$client->first_name}} {{$client->last_name}}</p>

                    <b class="card-title">Phone Number:</b>
                    <p class="card-text" id="clientPhone">{{$client->phone_number}}</p>

                    <b class="card-title">Language:</b>
                    <p class="card-text" id="clientLanguage">{{$client->language}}</p>
                </div>




        </div>


            @if($client->status == 'waiting_for_verification')
                <form action="{{route('clients.verify', ['client' => $client->id])}}" method="post">
                    @csrf
                    @method('post')
                    <p> An sms code was send to client phone number {{$client->phone_number}} for verification</p>

                    <p>
                        Please ask the client to provide the sms code, then submit the code to verify
                    </p>

                    <input type="text" class="form-control" name="verification_code" placeholder="example:  1010">

                    <div>
                        <button class="btn btn-primary">Verify</button>

                    </div>
                </form>

            @elseif($client->status == 'waiting_for_client_agreement')
                <div class="alert alert-success">
                    <p>Client is verified</p>
                    <p>A new sms was send, to verify client acceptance to TCPA, waiting client response</p>
                </div>
            @endif
        </div>


    </section>

@endsection
