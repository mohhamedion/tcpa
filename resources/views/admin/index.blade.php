@extends('admin.layers.layout')
@section('content')


    <section class="container">

        <h2>mini doc</h2>
        <div class="alert alert-warning">
            <p>On this page, you can find all created companies, and agents that belong to that company</p>
            <a href="{{route('companies.index')}}">Companies</a>
        </div>

    </section>

@endsection
