@extends('layouts.app')



@push('style')
    <style>
        #dispaly_profile_image {
            height: 100px;
            width: 100px;
            display: none;
        }

        .profile_picture {
            height: 100px;
            width: 100px;
            margin: 10px;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit User Profiless</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('profile.show', $user->id) }}"> Back</a>
            </div>
        </div>
    </div>
    {!! Form::model($user, [
        'method' => 'PATCH',
        'route' => ['profile.update', $user->id],
        'enctype' => 'multipart/form-data',
    ]) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {!! Form::text('name', $user->name, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
            </div>
            @error('name')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {!! Form::text('email', $user->email, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
            </div>
            @error('email')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12" id="image_upload_field">
            <div class="form-group">
                <strong>Profile Image:</strong>
                <input type="file" class="form-control" name="image" id="image" onChange="img_pathUrl(this);">
            </div>

            @error('image')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        @if ($user->image)
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Profile Picture:</strong>
                    <img src="/{{ $user->image }}" alt="" srcset="" class="profile_picture">
                </div>
            </div>
        @endif

        <div class="col-xs-2 col-sm-2 col-md-2 mt-3">
            <img src="#" alt="#" id="dispaly_profile_image">
        </div>
    
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Password:</strong>
                {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
            </div>
            @error('password')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Confirm Password:</strong>
                {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password', 'class' => 'form-control']) !!}
                @error('confirm-password')
                    <div class="text-danger">{{ $message . '*' }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}


    <p class="text-center text-primary"><small></small></p>
@endsection
@push('script')
    <script>
        function img_pathUrl(input) {
            $("#dispaly_profile_image").css({
                "display": "block"
            });
            $("#image_upload_field").removeClass("col-xs-12 col-sm-12 col-md-12");
            $("#image_upload_field").addClass("col-xs-10 col-sm-10 col-md-10 mt-4");
            $('#dispaly_profile_image')[0].src = (window.URL ? URL : webkitURL).createObjectURL(input.files[0]);
        }
    </script>
@endpush
