<!DOCTYPE html>
<html>
<head>
    <title>TCPA</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #343a40;
            color: #ffffff;
        }
        .card {
            background-color: #212529;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .form-control {
            background-color: #495057;
            border-color: #6c757d;
            color: #ffffff;
        }
        .card-header {
            background-color: #007bff;
            color: #ffffff;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark ">
    @if(Auth::check())

    <a class="navbar-brand" href="/"><span class="badge badge-info">TCPA</span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="{{route('clients.index')}}">Clients</a>
            </div>
        </div>

    @endif



</nav>
@yield('content')

@if(session()->exists('error'))
<div class="alert alert-danger">{{session()->get('error')}}</div>
@endif
</body>
</html>
@stack("jquery")
<script>
</script>
