@extends('agent.layers.layout')
@section('content')

    <section class="container">
        <h2>Clients</h2>

        <a href="{{route('clients.createForm',['company_hash' => request()->attributes->get('company_hash')])}}" class="btn btn-success">{{__('Create new Client')}}</a>


        <table class="table table-bordered table-hover">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Client Name</th>
                <th scope="col">Phone Number</th>
                <th scope="col" class="text-center">status</th>
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

    </section>


@endsection
