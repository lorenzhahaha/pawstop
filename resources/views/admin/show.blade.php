@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 mx-auto">
            <div class="row">
                <div class="col-12 col-lg-4 col-xl-4 mb-5 mb-lg-0 mb-xl-0 text-center">
                    <div style="background-image: url(@if($user->avatar) {{ $user->avatar }} @else {{ asset('img/profile-default.png') }} @endif)" class="profile-avatar shadow mt-5"></div>
                </div>
                <div class="col-12 col-lg-8 col-xl-8 p-1 p-lg-5 p-xl-5">
                    <form action="{{ route('admin.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="full-name" style="margin-bottom: 0">
                                <small><b>{{ __('Full Name') }}</b></small>
                            </label>
                            <input type="text" class="form-control" name="name" id="full-name" placeholder="Your full name" value="{{ $user->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="username" style="margin-bottom: 0">
                                <small><b>{{ __('Username') }}</b></small>
                            </label>
                            <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}">
                        </div>

                        <div class="form-group">
                            <label for="email" style="margin-bottom: 0">
                                <small><b>{{ __('Email Address') }}</b></small>
                            </label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}">
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
