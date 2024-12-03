@extends('admin.layers.layout')
@section('content')


    <section class="container">
        <div class="container mt-5">
            <h2>Create Agent for company {{$company->name}}</h2>
            <form action="{{route('agents.store',['company' => $company->id])}}" method="POST">
            @method('POST')
            @csrf
            <!-- Name -->

                <div class="mb-3">
                    <label for="name" class="form-label">Agent Login</label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="Login" required>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Agent Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name" required>
                </div>


                <div class="mb-3">
                    <label for="name" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
                </div>

{{--                <div class="mb-3">--}}
{{--                    <label for="name" class="form-label">Company</label>--}}
{{--                    <select name="company_id" class="form-control">--}}
{{--                        @foreach($companies as $company)--}}
{{--                            <option value="{{$company->id}}">{{$company->name}}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}

            {{--                <!-- From Number -->--}}
            {{--                <div class="mb-3">--}}
            {{--                    <label for="from_number" class="form-label">From Number</label>--}}
            {{--                    <input type="text" class="form-control" id="from_number" name="from_number" placeholder="Enter from number" required>--}}
            {{--                </div>--}}

            {{--                <!-- Template for Verification Code -->--}}
            {{--                <div class="mb-3">--}}
            {{--                    <label for="template_for_verification_code" class="form-label">Template for Verification Code</label>--}}
            {{--                    <textarea class="form-control" id="template_for_verification_code" name="template_for_verification_code" rows="4" placeholder="Enter template for verification code" required>--}}
            {{--Your verification code is [code]. Please provide it to the agent to begin the consent process.</textarea>--}}
            {{--                </div>--}}

            {{--                <!-- Template for Accepting TCPA -->--}}
            {{--                <div class="mb-3">--}}
            {{--                    <label for="template_for_accepting_tcpa" class="form-label">Template for Accepting TCPA</label>--}}
            {{--                    <textarea class="form-control" id="template_for_accepting_tcpa" name="template_for_accepting_tcpa" rows="4" placeholder="Enter template for accepting TCPA" required>Consent Request for John Smith at [phone_number]--}}
            {{--Please reply "YES" to confirm that you consent to receive advertisement calls from [company_name].</textarea>--}}
            {{--                </div>--}}

            <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Create Agent</button>
            </form>
        </div>
    </section>

@endsection
