@extends('layouts.app')



@push('style')
    <style>
        .profile_picture{
            height: 100px;
            width: 100px;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
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
            <div class="col-xs-6 col-sm-6 col-md-6">
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
                        <label class="badge badge-success text-danger">{{ $v }}</label>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
