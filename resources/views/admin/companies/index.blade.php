@extends('admin.layers.layout')
@section('content')

    <section class="container">
        <h2>Companies</h2>

        <a href="{{route('companies.createForm')}}" class="btn btn-success">{{__('Create new company')}}</a>


        <table class="table table-bordered table-hover">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Company Name</th>
                <th scope="col" class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>

            @foreach($companies as $company)
                <tr class="text-white">
                    <th scope="row">{{$company->id}}</th>
                    <td>{{$company->name}}</td>
                    <td class="text-center">

                        <div class="btn-sm me-2">
                            <a href="{{route('companies.updateForm',['company' => $company->id])}}" class="btn btn-warning ">Edit</a>
                        </div>
                        <form action="{{route('companies.delete',['company' => $company->id])}}" method="post">
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
