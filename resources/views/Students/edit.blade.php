@extends('layouts.app')

@section('main')


<section class="section-5">
    <div class="container my-5">    
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Add Student</h1>

                    {{-- Replace '' with your route name --}}
                    <form action="{{ route('students.update', $student->id) }}" method="POST" id="registrationform">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name">Name*</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $student->name ?? '') }}" placeholder="Enter name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email">Email*</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $student->email ?? '') }}" placeholder="Enter email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="birthdate">Birthdate*</label>
                                <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', \Carbon\Carbon::parse($student->birthdate)->format('Y-m-d')) }}">
                                @error('birthdate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="gender">Gender*</label>
                                <select name="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $student->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $student->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $student->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="class">Class*</label>
                                <input type="text" name="class" class="form-control" value="{{ old('class', $student->class ?? '') }}" placeholder="Enter class">
                                @error('class') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="mobileno">Mobileno*</label>
                                <input type="number" name="mobileno" class="form-control" value="{{ old('mobileno', $student->mobileno ?? '') }}" placeholder="Enter mobile no">
                                @error('mobileno') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="state_id">State*</label>
                                <select name="state_id" id="state_id" class="form-control">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ old('state_id', $student->state_id ?? '') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @error('state_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="district_id">District*</label>
                                <select name="district_id" id="district_id" class="form-control">
                                    <option value="">Select District</option>
                                    @if(!empty($districts))
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" {{ old('district_id', $student->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('district_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="taluka_id">Taluka*</label>
                                <select name="taluka_id" id="taluka_id" class="form-control">
                                    <option value="">Select Taluka</option>
                                    @if(!empty($talukas))
                                        @foreach($talukas as $taluka)
                                            <option value="{{ $taluka->id }}" {{ old('taluka_id', $student->taluka_id ?? '') == $taluka->id ? 'selected' : '' }}>
                                                {{ $taluka->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('taluka_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Check for the selected state on page load
        var stateID = $('#state_id').val();
        var districtID = "{{ old('district_id', $student->district_id ?? '') }}";
        var talukaID = "{{ old('taluka_id', $student->taluka_id ?? '') }}";
    
        // If state is selected, trigger district fetch
        if (stateID) {
            fetchDistricts(stateID, districtID);
        }
    
        // Listen for changes in state
        $('#state_id').change(function () {
            var selectedState = $(this).val();
            fetchDistricts(selectedState);
        });
    
        // Listen for changes in district
        $('#district_id').change(function () {
            var selectedDistrict = $(this).val();
            fetchTalukas(selectedDistrict);
        });
    
        function fetchDistricts(stateID, selectedDistrict = null) {
            $.ajax({
                url: '/get-districts/' + stateID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#district_id').empty().append('<option value="">Select District</option>');
                    $.each(data, function (key, value) {
                        var selected = (key == selectedDistrict) ? 'selected' : '';
                        $('#district_id').append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
                    });
    
                    if (selectedDistrict) {
                        fetchTalukas(selectedDistrict, talukaID);
                    }
                }
            });
        }
    
        function fetchTalukas(districtID, selectedTaluka = null) {
            $.ajax({
                url: '/get-talukas/' + districtID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#taluka_id').empty().append('<option value="">Select Taluka</option>');
                    $.each(data, function (index, taluka) {
                        var selected = (taluka.id == selectedTaluka) ? 'selected' : '';
                        $('#taluka_id').append('<option value="' + taluka.id + '" ' + selected + '>' + taluka.name + '</option>');
                    });
                }
            });
        }
    });
    </script>