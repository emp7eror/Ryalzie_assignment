@extends('clients.layout')
@section('content')

    <div class="container">

        <div class="card">
            <div class="card-header">Client Page</div>
            <div class="card-body">


                <div class="card-body">
                    <h5 class="card-title">Name : {{ $clients->name }}</h5>
                    <p class="card-text">Address : {{ $clients->address }}</p>
                    <p class="card-text">Mobile : {{ $clients->mobile }}</p>
                </div>

                </hr>

            </div>
        </div>
    </div>
    @endsection
