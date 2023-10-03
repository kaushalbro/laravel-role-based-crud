@extends('layouts.app')

@push('style')
    <style>
        .btn_update_account {
            /* padding: 5px; */
            /* background-color: ; */
        }

        .profile_picture {
            height: 100px;
            width: 100px;
        }
    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>User Profile</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="/"> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $user->name }}
            </div>
        </div>
        @if ($user->image)
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Profile Picture:</strong>
                    <img src="/{{ $user->image }}" alt="" srcset="" class="profile_picture">
                </div>
            </div>
        @endif
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {{ $user->email }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Roles:</strong>
                @if (!empty($user->getRoleNames()))
                    @foreach ($user->getRoleNames() as $v)
                        <label class="badge badge-success text-danger fs-6">{{ $v }}</label>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permissions:</strong>
                @if (!empty($user->getAllPermissions()))
                    @foreach ($user->getAllPermissions() as $permission)
                        {{ $permission->name }},
                    @endforeach
                @endif
            </div>
        </div>

        <a href="{{ route('profile.edit', Auth::id()) }}" class="btn_update_account btn btn-primary col-2 mt-2 ms-2">Update
            Account</a>
    </div>
@endsection
