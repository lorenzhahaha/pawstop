@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-xl-10 mx-auto">
            @if($count > 0)
                <div class="d-block mb-4">
                    <h2>Removed Users</h2>
                </div>
                <div class="shadow rounded bg-white p-4">
                    <div class="table-responsive" style="max-height: 800px;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col" class="text-center">Avatar</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email Address</th>
                                    <th scope="col">Role</th>
                                    <th scope="col" class="text-center">Google Connected</th>
                                    <th scope="col" class="text-center">OTP Activated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{ $user->id }}</th>
                                        <td class="text-center">
                                            <img src="@if($user->avatar) {{ $user->avatar }} @else {{ asset('img/profile-default.png') }} @endif" class="avatar shadow-sm" alt="Avatar Icon {{ $user->id }}">
                                        </td>
                                        <td>{{ ucwords($user->name) }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td class="text-center">
                                            @if($user->google_id)
                                                {!! '<i class="fas fa-check"></i>' !!}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($user->google2fa_secret)
                                                {!! '<i class="fas fa-check"></i>' !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="text-center">
                    <img src="{{ asset('img/empty-list-icon.png') }}" class="mb-2 mt-5 mb-5" alt="Empty List Icon" style="width: 25%">
                    <h3>
                        <b>Bow - wow ...</b>
                    </h3>
                    <h5 class="mb-5">The list is currently empty!</h5>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
