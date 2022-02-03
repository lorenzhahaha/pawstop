@extends('layouts.main')

@section('content')
<div class="container pt-5 pb-5">
    <div class="row">
        <div class="col-8 mx-auto">
            <div class="row vertical-align">
                <div class="col-12 col-lg-4 col-xl-4 mb-5 mb-lg-0 mb-xl-0 text-center">
                    <img src="{{ asset('img/security-page-img.png') }}" alt="Security Icon" style="width: 100%">
                </div>
                <div class="col-12 col-lg-8 col-xl-8 p-1 p-lg-5 p-xl-5">
                    <div class="text-center text-lg-left text-xl-left">
                        <h3>
                            <b>Protection is the key!</b>
                        </h3>
                        <h5 class="mb-4">
                            Secure your account by setting up a One-Time Password (OTP).
                        </h5>

                        <small>
                            <b><i class="fas fa-question"></i> Guideline:</b>
                        </small>

                        <p class="mb-5">
                            The OTP will always be needed when you are logging in. For this, <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank" rel="external" style="text-decoration: none">Google Authenticator<i class="fas fa-external-link-alt ml-1 fa-xs"></i></a> will be needed to scan the barcode or input the key that will be provided by us upon setting up of your OTP.
                        </p>
                    </div>

                    @if(Auth::user()->google2fa_secret)
                        <a href="{{ route('security-deactivate') }}" class="btn btn-danger btn-block rounded-button">
                            <i class="fas fa-exclamation mr-2"></i>{{ __('Deactivate OTP') }}
                        </a>
                    @else
                        <a href="{{ route('security-setup') }}" class="btn btn-light btn-block rounded-button">
                            <i class="fas fa-exclamation mr-2"></i>{{ __('Setup OTP') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
