@extends('layouts.app')

@section('content')
<div class="container pt-5 pb-5">
    <div class="row">
        <div class="col-10 col-lg-8 col-xl-5 mx-auto text-center">
            <img src="{{ asset('img/register-page-img.png') }}" class="mb-2" alt="Register Page Image" style="width: 25%">
            <h3>
                <b>Woof - woof ...</b>
            </h3>
            <h5 class="mb-5">The dogs are waiting for you! Sign up now!</h5>

            <div class="text-center mb-3">
                <a href="{{ route('google-redirect-register') }}" class="btn btn-light btn-block rounded-button mt-3 mr-3">
                    <img src="{{ asset('img/google-icon.png') }}" class="mr-2" alt="Google Icon" width="24" height="24">
                    {{ __('Sign Up with Google') }}
                </a>
            </div>

            <span class="d-block mb-3 text-center">
                <small><b>-- OR --</b></small>
            </span>

            <form action="{{ route('register') }}" id="register-form" method="POST" class="text-left">
                @csrf

                <div class="form-group">
                    <label for="full-name" style="margin-bottom: 0">
                        <small><b>{{ __('Full Name') }}</b></small>
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="full-name" placeholder="Your full name" value="{{ old('name') }}" required autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username" style="margin-bottom: 0">
                        <small><b>{{ __('Username') }}</b></small>
                    </label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="Your username" value="{{ old('username') }}" required>

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username" style="margin-bottom: 0">
                        <small><b>{{ __('Email Address') }}</b></small>
                    </label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Your email address" value="{{ old('email') }}" required>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" style="margin-bottom: 0">
                        <small><b>{{ __('Password') }}</b></small>
                    </label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Your password" required>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirmation" style="margin-bottom: 0">
                        <small><b>{{ __('Confirm Password') }}</b></small>
                    </label>
                    <div class="input-group mb-5">
                        <input type="password" class="form-control" name="password_confirmation" id="password-confirmation" placeholder="Your password" required>
                    </div>
                </div>

                <div class="form-group text-center mt-4">
                    <div class="g-recaptcha d-inline-block" data-theme="light" data-sitekey="{{ config('app.captcha.site_key') }}"></div>

                    @error('g-recaptcha-response')
                        <span class="text-danger d-block">
                            <small><strong>{{ $message }}</strong></small>
                        </span>
                    @enderror
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary rounded-button mr-3">
                        <i class="fas fa-check mr-2"></i>{{ __('Sign Up') }}
                    </button>
                </div>

                <div class="form-group text-center">
                    <a href="{{ route('login') }}" class="btn btn-link" style="text-decoration: none;">
                        <small>{{ __('Already have an account? Login now!') }}</small>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
