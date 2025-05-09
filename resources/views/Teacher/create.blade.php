@extends('layouts.app')

@section('main')

<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Admin Panel</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item active">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.index') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Students</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('teacher.index') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Teacher</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('change.password') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>change Password</span>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <ul class="navbar-nav ml-auto">
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- User Info -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>

                            @if(Auth::user()->profile_image)
                                <img class="img-profile rounded-circle" 
                                    src="{{ asset('profile_images/' . Auth::user()->profile_image) }}">
                            @else
                                <img class="img-profile rounded-circle" 
                                    src="{{ asset('default-user.png') }}">
                            @endif
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End Topbar -->

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
                        <div class="col-md-8">
                            <div class="card shadow border-0 p-5">
                                <h1 class="h3">Add Teacher</h1>
                                <form action="{{ route('teacher.store') }}" method="POST" id="registrationform">
                                    @csrf

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="name">Name*</label>
                                            <input type="text" name="name" class="form-control typeahead" value="{{ old('name', $teacher->name ?? '') }}" placeholder="Enter name">
                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email">Email*</label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->email ?? '') }}" placeholder="Enter email">
                                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="birthdate">Birthdate*</label>
                                            <input type="date" name="birthdate" class="form-control" 
                                                   value="{{ old('birthdate', isset($teacher) ? \Carbon\Carbon::parse($teacher->birthdate)->format('Y-m-d') : '') }}">
                                            @error('birthdate') 
                                                <span class="text-danger">{{ $message }}</span> 
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="gender">Gender*</label>
                                            <select name="gender" class="form-control">
                                                <option value="">Select Gender</option>
                                                <option value="Male" {{ old('gender', $teacher->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('gender', $teacher->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ old('gender', $teacher->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="mobileno">Mobile No*</label>
                                            <input type="text" name="mobileno" class="form-control" value="{{ old('mobileno', $teacher->mobileno ?? '') }}" placeholder="Enter Mobile No">
                                            @error('mobileno') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="state_id">State*</label>
                                            <select name="state_id" id="state_id" class="form-control">
                                                <option value="">Select State</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}" {{ old('state_id', $teacher->state_id ?? '') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('state_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="university_id">University*</label>
                                            <select name="university_id" id="university_id" class="form-control">
                                                <option value="">Select University</option>
                                            </select>
                                            @error('university_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="college_id">College*</label>
                                            <select name="college_id" id="college_id" class="form-control">
                                                <option value="">Select College</option>
                                            </select>
                                            @error('college_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#state_id').on('change', function () {
            var stateID = $(this).val();
            $('#university_id').html('<option>Loading...</option>');
            $('#college_id').html('<option value="">Select College</option>');

            if (stateID) {
                $.ajax({
                    url: '/get-university/' + stateID,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#university_id').empty().append('<option value="">Select University</option>');
                        $.each(data, function (key, value) {
                            $('#university_id').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#university_id').html('<option value="">Select University</option>');
            }
        });

        $('#university_id').on('change', function () {
            var universityID = $(this).val();
            $('#college_id').html('<option>Loading...</option>');

            if (universityID) {
                $.ajax({
                    url: '/get-college/' + universityID,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#college_id').empty().append('<option value="">Select College</option>');
                        $.each(data, function (index, college) {
                            $('#college_id').append('<option value="' + college.id + '">' + college.name + '</option>');
                        });
                    }
                });
            } else {
                $('#college_id').html('<option value="">Select College</option>');
            }
        });

        $('#state_id').trigger('change');
    });
</script>

<!-- jQuery UI CSS & JS -->
<script>
    var path = "{{ route('teacher.autocomplete') }}";

    $('input.typeahead').typeahead({
        source: function (query, process) {
            return $.get(path, { value: query }, function (data) {
                return process(data);
            });
        }
    });
</script>

@endsection
