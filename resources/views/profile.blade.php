@extends('layouts.main')

@section('content')
<div class="container pt-5 pb-5">
    <div class="row">
        <div class="col-10 mx-auto">
            <div class="row">
                <div class="col-12 col-lg-4 col-xl-4 mb-5 mb-lg-0 mb-xl-0 text-center">
                    <div style="background-image: url(@if(Auth::user()->avatar) {{ Auth::user()->avatar }} @else {{ asset('img/profile-default.png') }} @endif)" class="profile-avatar shadow mt-5"></div>

                    <button class="btn btn-light rounded-button mt-4">
                        <i class="fas fa-pen-nib mr-2"></i>Update Avatar
                    </button>
                </div>
                <div class="col-12 col-lg-8 col-xl-8 p-1 p-lg-5 p-xl-5">
                    <div class="row">
                        @if(Auth::user()->google_id)
                            <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                <span class="rounded-button shadow-sm p-3 d-block @if(Auth::user()->google2fa_secret) mb-3 @endif">
                                    <img src="{{ asset('img/google-icon.png') }}" class="mr-2" alt="Google Icon" width="24" height="24">
                                    {{ __('Account Connected') }}
                                </span>
                            </div>
                        @endif

                        @if(Auth::user()->google2fa_secret)
                            <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                <span class="rounded-button shadow-sm p-3 d-block">
                                    <img src="{{ asset('img/otp-icon.png') }}" class="mr-2" alt="OTP Icon" width="24" height="24">
                                    {{ __('OTP Activated') }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('update-profile') }}" method="POST" class="@if(Auth::user()->google_id || Auth::user()->google2fa_secret) mt-4 @endif">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="full-name" style="margin-bottom: 0">
                                <small><b>{{ __('Full Name') }}</b></small>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="full-name" placeholder="Your full name" value="{{ old('name') ? old('name') : Auth::user()->name }}" required>

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
                            @if(Auth::user()->username)
                                <div class="input-lock mb-3">
                                    <input type="text" class="form-control" id="username" value="{{ Auth::user()->username }}" style="padding-right: 20px !important" disabled>
                                    <span class="fas fa-lock"></span>
                                </div>
                            @else
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Your username" value="{{ old('username') }}">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <small class="d-block mt-1" style="color: #757575">
                                    <b class="d-block">Ruff-ruff! You have no username yet. Create one now!</b>
                                </small>
                            @endif
                        </div>

                        <div class="formr-group">
                            <label for="email" style="margin-bottom: 0">
                                <small><b>{{ __('Email Address') }}</b></small>
                            </label>
                            <div class="input-lock mb-3">
                                <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" style="padding-right: 20px !important" disabled>
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" style="margin-bottom: 0">
                                <small><b>{{ __('Password') }}</b></small>
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Your password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <small class="d-block mt-1" style="color: #757575">
                                @if(!Auth::user()->password)
                                    <b class="d-block">Ruff-ruff! You have no password yet. Create one now!</b>
                                @endif
                                <span class="d-block">
                                    Leave blank if not updating password.
                                </span>
                            </small>
                        </div>

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary rounded-button">
                                <i class="fas fa-check mr-2"></i>{{ __('Save Profile') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
