@extends('layouts.app')

@section('content')
<div class="container pt-5 pb-5">
    <div class="row">
        <div class="col-10 col-lg-8 col-xl-5 mx-auto text-center">
            <img src="{{ asset('img/forgot-password-img.png') }}" class="mb-2" alt="Forgot Password Image" style="width: 50%">
            <h3>
                <b>Dogs are now waiting for you!</b>
            </h3>
            <h5 class="mb-5">Please confirm your password before continuing..</h5>

            <form action="{{ route('password.confirm') }}" method="POST" class="text-left">
                @csrf

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

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary rounded-button mr-3">
                        <i class="fas fa-check mr-2"></i>{{ __('Confirm Password') }}
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
