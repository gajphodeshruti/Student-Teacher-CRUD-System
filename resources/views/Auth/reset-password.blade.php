@extends('layouts.app')

@section('main')

<section class="section-5">
    <div class="container my-5">
        @if (Session::has('success'))
        <div class="alert alert-success">
            <p>{{ Session::get('success') }}</p>
        </div>
    @endif

    @if (Session::has('error'))
    <div class="alert alert-danger">
        <p>{{ Session::get('error') }}</p>
    </div>
    @endif
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Login</h1>
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ request()->token }}">
                        <div class="mb-3">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span> 
                         @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="mb-2">Password*</label>
                            <input type="password" class="form-control" name="password" placeholder="New Password"  value="{{ old('password') }}">
                            @error('password')
                            <span class="text-danger">{{ $message }}</span> 
                         @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="mb-2">Confirm Password*</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"  value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span> 
                         @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary mt-2">Reset Password</button>
                        </div>
            </div>
        </div>
    </div>

@endsection