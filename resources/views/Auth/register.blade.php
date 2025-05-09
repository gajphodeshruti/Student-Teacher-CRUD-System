@extends('layouts.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Registration Form</h1>

                    <form id="register-form" action="{{ route('register') }}">
                        @csrf
                        <select name="role" class="form-control" required>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="admin">Admin</option>
                        </select>
                        <div class="mb-3">
                            <label for="name">Name:</label>
                            <input type="text" id="name" class="form-control" name="name" placeholder="Enter your name">
                            <div class="text-danger error-name"></div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email:</label>
                            <input type="email" id="email" class="form-control" name="email" placeholder="Enter your email">
                            <div class="text-danger error-email"></div>
                        </div>

                        <div class="mb-3">
                            <label for="password">Password:</label>
                            <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password">
                            <div class="text-danger error-password"></div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation">Confirm Password:</label>
                            <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Confirm your password">
                            <div class="text-danger error-password_confirmation"></div>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>

                <div class="mt-4 text-center">
                    <p>Already have an account? <a href="{{ route('login.view') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#register-form').submit(function (e) {
            e.preventDefault();
            $('.text-danger').html(''); // clear errors

            $.ajax({
                type: 'POST',
                url: "{{ route('register') }}",
                data: $(this).serialize(),
                success: function (response) {
                    if (response.status) {
                        alert("Registration successful!");
                        window.location.href = response.redirect_url;
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, messages) {
                            $('.error-' + key).html(messages[0]);
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
