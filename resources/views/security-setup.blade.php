@extends('layouts.main')

@section('content')
<div class="container pt-5 pb-5">
    <div class="row">
        <div class="col-10 mx-auto">
            <div class="row vertical-align">
                <div class="col-12 col-lg-3 col-xl-3 mb-5 mb-lg-0 mb-xl-0 text-center">
                    <img src="{{ asset('img/security-page-img.png') }}" alt="Security Icon" style="width: 100%">
                </div>
                <div class="col-12 col-lg-9 col-xl-9 p-1 p-lg-5 p-xl-5">
                    <div class="text-center text-lg-left text-xl-left">
                        <h3>
                            <b>Unique Keys Generated!</b>
                        </h3>
                        <p class="mb-4">
                            You can scan the barcode below. Alternatively, you can use the code <b>{{ $secret }}</b> for manual entry. Kindly use <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank" rel="external" style="text-decoration: none">Google Authenticator<i class="fas fa-external-link-alt ml-1 fa-xs"></i></a>.
                        </p>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12 col-xl-4 col-lg-5">
                            <div class="d-block mb-4 text-center">
                                {!! $qr_code !!}
                            </div>
                        </div>
                        <div class="col-12 col-xl-8 col-lg-7">
                            <p class="mb-4">
                                After scanning, enter the generated code below to complete setup.
                            </p>

                            <form action="{{ route('security-setup-complete') }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="form-group">
                                    <label for="2fa_verification_code" style="margin-bottom: 0">
                                        <small><b>{{ __('2FA Verification Code') }}</b></small>
                                    </label>
                                    <input type="text" class="form-control @error('2fa_verification_code') is-invalid @enderror" name="2fa_verification_code" id="2fa_verification_code" placeholder="2FA Verification Code" value="{{ old('2fa_verification_code') }}" required>

                                    @error('2fa_verification_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group text-center mt-4">
                                    <button type="submit" class="btn btn-light btn-block rounded-button mr-3">
                                        <i class="fas fa-check mr-2"></i>{{ __('Complete Setup') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
