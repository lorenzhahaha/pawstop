@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-10 col-lg-10 col-xl-5 mx-auto text-center">
            <form action="{{ route('admin.store') }}" id="register-form" method="POST" class="text-left">
                @csrf

                <label for="full-name" style="margin-bottom: 0">
                    <small><b>{{ __('Full Name') }}</b></small>
                </label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="full-name" placeholder="Your full name" value="{{ old('name') }}" required>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <label for="username" style="margin-bottom: 0">
                    <small><b>{{ __('Username') }}</b></small>
                </label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="Your username address" value="{{ old('username') }}" required>

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <label for="email" style="margin-bottom: 0">
                    <small><b>{{ __('Email Address') }}</b></small>
                </label>
                <div class="input-group mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Your email address" value="{{ old('email') }}" required>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary rounded-button mr-3">
                        <i class="fas fa-check mr-2"></i>{{ __('Add User') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
