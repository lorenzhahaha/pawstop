@extends('layouts.app')

@section('content')
<div class="container pt-5 pb-5">
    <div class="row">
        <div class="col-10 col-md-8 col-lg-6 col-xl-4 mx-auto text-center">
            <img src="{{ asset('img/security-page-img.png') }}" class="mb-2" alt="Security Page Image" style="width: 50%">
            <h3>
                <b>Arf - Arf ...</b>
            </h3>
            <h5 class="mb-5">Please enter your One-Time Password to finish your login process.</h5>

            <form action="{{ route('post-otp-validate') }}" method="POST" class="text-left">
                @csrf

                <label for="otp-code" style="margin-bottom: 0">
                    <small><b>{{ __('One-Time Password') }}</b></small>
                </label>
                <div class="input-group mb-3">
                    <input type="number" class="form-control @error('totp') is-invalid @enderror" name="totp" id="otp-code" placeholder="Your code" autofocus required>

                    @error('totp')
                        <span class="invalid-feedback" role="alert">
                            <strong>That code is invalid. Please try again.</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary rounded-button mr-3">
                        <i class="fas fa-check mr-2"></i>{{ __('Proceed') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready( function($) {
        // Disable scroll when focused on a number input.
        $('form').on('focus', 'input[type=number]', function(e) {
            $(this).on('wheel', function(e) {
                e.preventDefault()
            })
        })

        // Restore scroll on number inputs.
        $('form').on('blur', 'input[type=number]', function(e) {
            $(this).off('wheel')
        })

        // Disable up and down keys.
        $('form').on('keydown', 'input[type=number]', function(e) {
            if ( e.which == 38 || e.which == 40 )
                e.preventDefault()
        })
    })
</script>
@endsection