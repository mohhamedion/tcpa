@extends('agent.layers.layout')
@section('content')

    <section class="container">
        <h2>Clients</h2>

        <a href="{{route('clients.createForm',['company_hash' => request()->attributes->get('company_hash')])}}" class="btn btn-success">{{__('Create new Client')}}</a>

        <form method="GET" action="{{ route('clients.index', ['company_hash' => request()->attributes->get('company_hash')]) }}">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">{{ __('All') }}</option>
                        @foreach(\App\Enums\Client\Statuses::cases() as $status)
                            <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="date" class="form-label">{{ __('Date') }}</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                </div>

                <div class="col-md-3">
                    <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="{{ __('Search by phone number') }}" value="{{ request('phone_number') }}">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">{{ __('Filter') }}</button>
                    <a href="{{ route('clients.index', ['company_hash' => request()->attributes->get('company_hash')]) }}" class="btn btn-secondary">{{ __('Reset') }}</a>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Client Name</th>
                <th scope="col">Phone Number</th>
                <th scope="col" class="text-center">status</th>
                <th scope="col" class="text-center">Created at</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>

            @foreach($clients as $client)
                <tr class="text-white">
                    <th scope="row">{{$client->id}}</th>
                    <td><a href="{{route('clients.show',['client' => $client->id,'company_hash' => request()->attributes->get('company_hash')])}}">{{$client->first_name.' '.$client->last_name}}</a></td>
                    <td>{{$client->phone_number}}</td>
                    <td>{{\App\Enums\Client\Statuses::from($client->status)->label()}}</td>
                    <td>{{$client->created_at}}</td>
                    <td>
                        <form action="{{route('clients.delete',['client' => $client->id,'company_hash' => request()->attributes->get('company_hash')])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <!-- Add more rows dynamically as needed -->
            </tbody>
        </table>
        <div class="mt-3">
            {{ $clients->appends(request()->query())->links() }}
        </div>
    </section>


@endsection
