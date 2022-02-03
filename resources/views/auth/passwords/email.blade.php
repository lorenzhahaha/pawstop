@extends('layouts.app')

@section('content')
<div class="container pt-5 pb-5">
    <div class="row">
        <div class="col-10 col-lg-8 col-xl-5 mx-auto text-center">
            <img src="{{ asset('img/forgot-password-img.png') }}" class="mb-3" alt="Forgot Password Image" style="width: 50%">
            <h3>
                <b>Dogs need a friend!</b>
            </h3>
            <h5 class="mb-4">Please complete needed fields below.</h5>

            <p class="mb-4">
                If your email exists in our records, we will send a <b>Password Reset Link</b> to that email. Open the link and you will be able to reset your password.
            </p>

            <form action="{{ route('password.email') }}" method="POST" class="text-left">
                @csrf

                <label for="username" style="margin-bottom: 0">
                    <small><b>{{ __('Email Address') }}</b></small>
                </label>
                <div class="input-group mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="username" placeholder="Your email address" value="{{ old('email') }}" autofocus required>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group text-center mt-5">
                    <button type="submit" class="btn btn-light rounded-button mr-3">
                        <i class="fas fa-paper-plane mr-2"></i>{{ __('Send Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
