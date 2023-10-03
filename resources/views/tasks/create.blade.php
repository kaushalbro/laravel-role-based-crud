@extends('layouts.app')
@push('style')
    <style>
        .priority_task select,
        #assigned_to {
            width: 100%;
            height: 40px;
            border-radius: 10px;
        }
    </style>
@endpush
@section('content')
    {{-- login form started --}}
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Create New Task</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('tasks.index') }}"> Back</a>
            </div>
        </div>
    </div>
    {!! Form::open(['route' => 'tasks.store', 'method' => 'POST']) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
            </div>
            @error('name')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                {!! Form::text('description', null, ['placeholder' => 'Description', 'class' => 'form-control']) !!}
            </div>
            @error('description')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Task Type:</strong>
                {!! Form::text('type', null, ['placeholder' => 'type', 'class' => 'form-control']) !!}
            </div>
            @error('type')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-2">
            <div class="form-group priority_task">
                <strong>Task Priority:</strong>
                <select name="priority" id="priority">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            @error('priority')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Deadline:</strong>
                {!! Form::datetimelocal('deadline', now(), ['placeholder' => 'deadline', 'class' => 'form-control']) !!}
            </div>
            @error('deadline')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 pt-3">
            <div class="form-group">
                <strong>Assign to user:</strong>
                <select name="assigned_to" id="assigned_to">
                    <option value="not-assigned" selected>Not assign</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('assigned_to')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
    {{-- login form ended --}}
    <p class="text-center text-primary"><small></small></p>
@endsection
@push('script')
    <script>
        var today = new Date().toISOString().slice(0, 16);
        // document.getElementsByName("deadline")[0].min = today;
    </script>
@endpush
