@extends('admin.layers.layout')
@section('content')

    <section class="container">
        <h2>Agents of company {{$company->name}}</h2>

        <a href="{{route('agents.createForm',['company' => $company->id])}}" class="btn btn-success">{{__('Create Agent')}}</a>


        <table class="table table-bordered table-hover">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Agent Name</th>
                <th scope="col" class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>

            @foreach($agents as $agent)
                <tr class="text-white">
                    <th scope="row">{{$company->id}}</th>
                    <td>{{$agent->name}}</td>
                    <td class="text-center">

                        <div class="btn-sm me-2">
                            <a href="{{route('agents.updateForm',['user' => $agent->id,'company' => $company->id])}}" class="btn btn-warning ">Edit</a>
                        </div>
                        <form action="{{route('agents.delete',['user' => $agent->id])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <!-- Add more rows dynamically as needed -->
            </tbody>
        </table>

    </section>

@endsection
