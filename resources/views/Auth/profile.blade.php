@extends('layouts.app')

@section('main')
<form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label>Upload Profile Image:</label><br>
        <input type="file" name="profile_image">
    </div>
    <button type="submit">Upload</button>
</form>

@if(Auth::user()->profile_image)
    <img src="{{ asset('profile_images/' . Auth::user()->profile_image) }}" width="100" alt="Profile Image">
@else
    <p>No image uploaded.</p>
@endif

@endsection