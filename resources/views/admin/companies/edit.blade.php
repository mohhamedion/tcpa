@extends('admin.layers.layout')
@section('content')


    <section class="container">
        <div class="container mt-5">
            <h2>Create Company</h2>
            <form action="{{route('companies.update')}}" method="POST">
            @method('POST')
            <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Company Name</label>
                    <input type="text" class="form-control" value="{{$company->name}}" id="name" name="name" placeholder="Enter company name" required>
                </div>

                <!-- From Number -->
                <div class="mb-3">
                    <label for="from_number" class="form-label">From Number</label>
                    <input type="text" class="form-control" value="{{$company->from_number}}" id="from_number" name="from_number" placeholder="Enter from number" required>
                </div>

                <!-- Template for Verification Code -->
                <div class="mb-3">
                    <label for="template_for_verification_code" class="form-label">Template for Verification Code</label>
                    <textarea class="form-control" id="template_for_verification_code" name="template_for_verification_code" rows="4" placeholder="Enter template for verification code" required>
                         {{$company->template_for_verification_code}}
                    </textarea>
                </div>

                <!-- Template for Accepting TCPA -->
                <div class="mb-3">
                    <label for="template_for_accepting_tcpa" class="form-label">Template for Accepting TCPA</label>
                    <textarea class="form-control" id="template_for_accepting_tcpa" name="template_for_accepting_tcpa" rows="4" placeholder="Enter template for accepting TCPA" required>
                        {{$company->template_for_accepting_tcpa}}
                    </textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Create Company</button>
            </form>
        </div>
    </section>

@endsection
