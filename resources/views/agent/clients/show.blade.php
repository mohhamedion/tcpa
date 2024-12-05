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

                    <b class="card-title">Status:</b>
                    <p class="card-text" id="clientLanguage">{{$client->status}}</p>

                </div>




        </div>
            @if($client->status == 'created')

                <form action="{{route('clients.send-verification-code',['client' => $client->id,'company_hash' => request()->attributes->get('company_hash')])}}">
                    @csrf
                    @method('POST')
                    <br>
                    <button class="btn btn-success">Resend sms code</button>
                </form>

            @elseif($client->status == 'waiting_for_verification')
                <form action="{{route('clients.verify', ['client' => $client->id,'company_hash' => request()->attributes->get('company_hash')])}}" method="post">
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

                <a href="#" class="text-danger" onclick="fakeWebhook('YES')">Fake receiving webhook YES</a>
                <br>
                <a href="#" class="text-danger" onclick="fakeWebhook('NO')">Fake receiving webhook NO</a>

            @endif
        </div>



    </section>
    <script>
        // Define the data to send in the POST request


        function fakeWebhook(answer){
            const generateRandomValue = (prefix = '') => prefix + Math.random().toString(36).substring(2, 10);

            const data = {
                MessageSid: generateRandomValue('MSG'),
                SmsSid: generateRandomValue('SMS'),
                SmsMessageSid: generateRandomValue('SMSMSG'),
                AccountSid: generateRandomValue('ACCT'),
                MessagingServiceSid: generateRandomValue('MSS'),
                From: '{{$client->phone_number}}', // Replace with a fixed or dynamic value
                To: '+0987654321',   // Replace with a fixed or dynamic value
                Body: answer, // Replace with desired content
                NumMedia: Math.floor(Math.random() * 10).toString(), // Random number as a string
                NumSegments: Math.floor(Math.random() * 5).toString(), // Random number as a string
            };


            // Make the POST request using fetch
            fetch("{{route('twilio.webhook',['company_hash' => request()->attributes->get('company_hash')])}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json(); // Assuming the server returns a JSON response
                })
                .then(result => {
                    console.log('Success:', result);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

    </script>

@endsection
