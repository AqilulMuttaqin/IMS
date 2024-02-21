@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body pb-0 px-0 px-md-4 text-center">
                <div class="gif mb-3">
                    <h2 style="position: absolute; left: 50%; transform: translateX(-50%);">Scan Kode Disini!</h2>
                    <img src="{{ asset('images/scan.gif')}}" alt="GIF Image" style="width: 75%">
                </div>
            </div>
        </div>
    </div>
@endsection
