@extends('layouts.app')

@section('main')


1<section class="section-5">
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
                    <h1 class="h3">Edit Teacher</h1>
                    <form action="{{ route('teacher.update', $teacher->id) }}" method="POST" id="registrationform">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name">Name*</label>
                                <input id="name" type="text" name="name" class="form-control"
                                       value="{{ old('name', $teacher->name) }}" placeholder="Enter name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email">Email*</label>
                                <input id="email" type="email" name="email" class="form-control"
                                       value="{{ old('email', $teacher->email) }}" placeholder="Enter email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="birthdate">Birthdate*</label>
                                <input id="birthdate" type="date" name="birthdate" class="form-control"
                                value="{{ old('birthdate', \Carbon\Carbon::parse($teacher->birthdate)->format('Y-m-d')) }}">
                                @error('birthdate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="gender">Gender*</label>
                                <select id="gender" name="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $teacher->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $teacher->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $teacher->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="mobileno">Mobile No*</label>
                                <input id="mobileno" type="text" name="mobileno" class="form-control"
                                       value="{{ old('mobileno', $teacher->mobileno) }}" placeholder="Enter Mobile No">
                                @error('mobileno') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="state_id">State*</label>
                                <select id="state_id" name="state_id" class="form-control">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ old('state_id', $teacher->state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @error('state_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="university_id">University*</label>
                                <select id="university_id" name="university_id" class="form-control">
                                    <option value="">Select University</option>
                                </select>
                                @error('university_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="college_id">College*</label>
                                <select id="college_id" name="college_id" class="form-control">
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
        function fetchUniversities(stateID, selectedID = '') {
            if (stateID) {
                $('#university_id').html('<option>Loading...</option>');
                $.getJSON('/get-university/' + stateID)
                    .done(function (data) {
                        $('#university_id').empty().append('<option value="">Select University</option>');
                        $.each(data, function (key, value) {
                            $('#university_id').append('<option value="' + key + '"' + (key == selectedID ? ' selected' : '') + '>' + value + '</option>');
                        });
                    })
                    .fail(function () {
                        alert("Error loading universities.");
                        $('#university_id').html('<option value="">Select University</option>');
                    });
            } else {
                $('#university_id').html('<option value="">Select University</option>');
            }
        }
    
        function fetchColleges(universityID, selectedID = '') {
            if (universityID) {
                $('#college_id').html('<option>Loading...</option>');
                $.getJSON('/get-college/' + universityID)
                    .done(function (data) {
                        $('#college_id').empty().append('<option value="">Select College</option>');
                        $.each(data, function (index, college) {
                            // Assuming 'college' contains the object with name and id
                            $('#college_id').append('<option value="' + college.id + '"' + (college.id == selectedID ? ' selected' : '') + '>' + college.name + '</option>');
                        });
                    })
                    .fail(function () {
                        alert("Error loading colleges.");
                        $('#college_id').html('<option value="">Select College</option>');
                    });
            } else {
                $('#college_id').html('<option value="">Select College</option>');
            }
        }
    
        let selectedState = '{{ old("state_id", $teacher->state_id) }}';
        let selectedUniversity = '{{ old("university_id", $teacher->university_id) }}';
        let selectedCollege = '{{ old("college_id", $teacher->college_id) }}';
    
        if (selectedState) {
            fetchUniversities(selectedState, selectedUniversity);
        }
    
        if (selectedUniversity) {
            fetchColleges(selectedUniversity, selectedCollege);
        }
    
        $('#state_id').change(function () {
            let stateID = $(this).val();
            $('#college_id').html('<option value="">Select College</option>');
            fetchUniversities(stateID);
        });
    
        $('#university_id').change(function () {
            let universityID = $(this).val();
            fetchColleges(universityID);
        });
    });
    </script>
 @endsection    