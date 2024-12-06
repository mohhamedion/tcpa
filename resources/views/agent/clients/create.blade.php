@extends('agent.layers.layout')
@section('content')

    <section class="container">

        <div class="container mt-5">
            <h2 class="text-center">Client Information Form</h2>
            <form action="{{route('clients.store',['company_hash' => request()->attributes->get('company_hash')])}}" method="post">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
                </div>
                <div class="mb-3">
                    <label for="phoneNumber" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number" required>
                </div>
                <div class="mb-3">
                    <label for="language" class="form-label">Preferred Language</label>
                    <select class="form-select form-control" id="language" name="language" required>
                        <option value="" disabled selected>Select language</option>
                        @foreach(\App\Enums\SmsContentTemplate\AvailableLanguages::cases() as $language)
                            <option value="{{$language->value}}">{{$language->label()}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

    </section>

@endsection

