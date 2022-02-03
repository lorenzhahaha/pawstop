@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-block mb-4">
                <a href="{{ route('admin.create') }}" class="btn btn-light float-right">
                    <i class="fas fa-plus"></i>
                    <span class="d-none d-sm-inline-block ml-2">Add User</span>
                </a>
                <h2>Manage Users</h2>
            </div>
            <div class="shadow rounded bg-white p-4">
                <div class="table-responsive" style="max-height: 800px;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">ID</th>
                                <th scope="col" class="text-center">Avatar</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">Role</th>
                                <th scope="col" class="text-center">Google Connected</th>
                                <th scope="col" class="text-center">OTP Activated</th>
                                <th scope="col" class="text-right" width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row" class="text-center">
                                        {{ $user->id }}
                                        @if(Auth::user()->id == $user->id)
                                            <span class="d-block">(You)</span>
                                        @endif
                                    </th>
                                    <td class="text-center">
                                        <div style="background-image: url(@if($user->avatar) {{ $user->avatar }} @else {{ asset('img/profile-default.png') }} @endif)" class="avatar shadow-sm d-inline-block"></div>
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
                                    <td class="text-right">
                                        <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-success btn-block-xs-only mb-1">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        @if(Auth::user()->id != $user->id)
                                            <a href="{{ route('admin.destroy', $user->id) }}" class="btn btn-danger btn-block-xs-only mb-1" onclick="event.preventDefault(); document.getElementById('delete-user-form').submit();">
                                                <i class="fas fa-trash"></i>
                                            </a>

                                            <form id="delete-user-form" action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group text-right mt-4">
                <a href="{{ route('deleted-users') }}" class="btn btn-link" style="text-decoration: none;">
                    <small>{{ __('Looking for someone? Show deleted users.') }}</small>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
