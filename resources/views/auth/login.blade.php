@extends('layouts.app')

@section('content')
<div class="container pt-5 pb-5">
    <div class="row">
        <div class="col-xl-8 d-none d-xl-block p-5">
            <img src="{{ asset('img/landing-page-img.png') }}" alt="Landing Page Image" style="width: 100%">
        </div>
        <div class="col-10 col-xl-4 mt-5 mt-md-0 mt-lg-0 mx-auto">
            <div class="text-center text-xl-left">
                <h3>
                    <b>Greetings!</b>
                </h3>
                <h5 class="mb-5">Please login to your account.</h5>
            </div>

            <div class="text-center mb-3">
                <a href="{{ route('google-redirect-login') }}" class="btn btn-light btn-block rounded-button mt-3 mr-3">
                    <img src="{{ asset('img/google-icon.png') }}" class="mr-2" alt="Google Icon" width="24" height="24">
                    {{ __('Login with Google') }}
                </a>
            </div>

            <span class="d-block mb-3 text-center">
                <small><b>-- OR --</b></small>
            </span>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="username" style="margin-bottom: 0">
                        <small><b>{{ __('Username') }}</b></small>
                    </label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="Your username" value="{{ old('username') }}" required autofocus>

                    @error('username')
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

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                <div class="form-group text-center mt-5">
                    <button type="submit" class="btn btn-primary rounded-button">
                        <i class="fas fa-check mr-2"></i>{{ __('Login') }}
                    </button>
                </div>

                @if (Route::has('password.request'))
                    <div class="form-group text-center">
                        <a class="btn btn-link" style="text-decoration: none;" href="{{ route('password.request') }}">
                            <small>{{ __('Forgot Your Password?') }}</small>
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
