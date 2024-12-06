@extends('agent.layers.layout')
@section('content')

    <section class="container">
        <h2>Twilio settings</h2>

        <p>You can access these data from your <a href="https://console.twilio.com/" target="_blank">twilio account</a></p>
        <p>If you're using test credentials, you can use this magic number +15005550006 for success operations</p>
        <form action="{{route('twilio-settings.update',['company_hash' => request()->attributes->get('company_hash')])}}" method="post">
            @csrf
            @method('POST')
            <label for="">Twilio number</label>
            <input type="text" class="form-control" name="phone_number" value="{{$companyTwilioSettings?->from_number}}" placeholder="From number" required>
            <label for="">Token</label>
            <input type="text" class="form-control" name="token" value="{{$companyTwilioSettings?->token}}" placeholder="Enter Token from your twilio account" required>
            <label for="">Sid</label>
            <input type="text" class="form-control" name="sid" value="{{$companyTwilioSettings?->sid}}" placeholder="Enter Sid from your twilio account" required>


            <div class="alert alert-info mt-5" role="alert">
                <h4 class="alert-heading">Your webhook</h4>
                <p>Copy your webhook and place it in your Twilio account:</p>
                <hr>
                <p class="mb-0">
                    <code id="webhook-link">{{route('twilio.webhook',['company_hash' => request()->attributes->get('company_hash')])}}</code>
                    <a  class="btn btn-sm btn-primary ml-2" onclick="copyToClipboard()">Copy</a>
                </p>
            </div>


            <br>
            <button class="btn btn-primary">Save</button>
        </form>

    </section>

    <script>
        function copyToClipboard() {
            const link = document.getElementById('webhook-link').textContent;
            navigator.clipboard.writeText(link).then(() => {
                alert('Webhook link copied to clipboard!');
            }).catch(err => {
                alert('Failed to copy: ' + err);
            });
        }
    </script>
@endsection
