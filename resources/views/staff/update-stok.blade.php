@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body pb-0 px-0 px-md-4 text-center">
                <div class="gif mb-3">
                    <img src="{{ asset('images/scan.gif')}}" alt="GIF Image" style="width: 70%">
                </div>
                <div class="button mb-3 p-3">
                    <button class="btn btn-primary">
                        SCAN
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection
