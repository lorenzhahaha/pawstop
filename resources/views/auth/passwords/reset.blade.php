@extends('layouts.app')

@section('content')
<div class="container pt-5 pb-5">
    <div class="row">
        <div class="col-10 col-lg-8 col-xl-5 mx-auto text-center">
            <img src="{{ asset('img/forgot-password-img.png') }}" class="mb-2" alt="Forgot Password Image" style="width: 50%">
            <h3>
                <b>Dogs need a friend!</b>
            </h3>
            <h5 class="mb-5">Please complete needed fields below.</h5>

            <form action="{{ route('password.update') }}" method="POST" class="text-left">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <label for="username" style="margin-bottom: 0">
                    <small><b>{{ __('Email Address') }}</b></small>
                </label>
                <div class="input-group mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="username" placeholder="Your email address" value="{{ $email ?? old('email') }}" required>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <label for="password" style="margin-bottom: 0">
                    <small><b>{{ __('Password') }}</b></small>
                </label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Your password" required>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <label for="password-confirmation" style="margin-bottom: 0">
                    <small><b>{{ __('Confirm Password') }}</b></small>
                </label>
                <div class="input-group mb-5">
                    <input type="password" class="form-control" name="password_confirmation" id="password-confirmation" placeholder="Your password" required>
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary rounded-button mr-3">
                        <i class="fas fa-check mr-2"></i>{{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
