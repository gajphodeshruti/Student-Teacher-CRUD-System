@extends('layouts.app')

@section('main')


<section class="section-5">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Login</h1>
                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary mt-2">Login</button>
                        </div>
            </div>
        </div>
    </div>

@endsection

