@extends('admin.layers.layout')
@section('content')


    <section class="container">

        <h2>Mini doc</h2>
        <div class="alert alert-info">
            <p>On this page, you can find all the companies created and the agents associated with each company.</p>
            <a href="{{route('companies.index')}}">Companies</a>
        </div>

    </section>

@endsection
