@extends('agent.layers.layout')
@section('content')

    <section class="container">
        <h2>Sms Messages</h2>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">From</th>
                <th scope="col">To</th>
                <th scope="col" class="text-center">Content</th>
            </tr>
            </thead>
            <tbody>

            @foreach($smsMessages as $message)
                <tr class="text-white">
                    <th scope="row">{{$message->id}}</th>
                    <td><b>{{$message->from_number}}</b></td>
                    <td>{{$message->to_number}}</td>
                    <td>{{$message->content}}</td>
                </tr>
            @endforeach
            <!-- Add more rows dynamically as needed -->
            </tbody>
        </table>

    </section>


@endsection
