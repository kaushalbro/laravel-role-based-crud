@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Update Task</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('tasks.index') }}"> Back</a>
            </div>
        </div>
    </div>
    {!! Form::model($task, ['method' => 'PATCH', 'route' => ['tasks.update', $task->id]]) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {!! Form::text('name', $task->name, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
            </div>
            @error('name')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                {!! Form::text('description', $task->description, ['placeholder' => 'Description', 'class' => 'form-control']) !!}
            </div>
            @error('description')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Task Type:</strong>
                {!! Form::text('type', $task->type, ['placeholder' => 'type', 'class' => 'form-control']) !!}
            </div>
            @error('type')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Deadline:</strong>
                {!! Form::datetimelocal('deadline', $task->deadline, ['placeholder' => 'deadline', 'class' => 'form-control']) !!}
            </div>
            @error('deadline')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 pt-3">
            <div class="form-group">
                <strong>Assign to user:</strong>
                <select name="assigned_to" id="assigned_to">
                    @foreach ($users as $user)
                        <option value={{ $user->id }}
                            {{ isset($task->user) && $task->user->name === $user->name ? 'selected' : '' }}>
                            {{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('assigned_to')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-2">
            <div class="form-group">
                <strong>Task Priority:</strong>
                <select name="priority" id="priority">
                    <option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>
            @error('priority')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 pt-3">
            <div class="form-group">
                <strong>Status:</strong>
                <select name="status" id="status">
                    <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>
                    <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>
                        Completed
                    </option>
                    <option value="in-progress" {{ $task->status === 'in-progress' ? 'selected' : '' }}>
                        In Progress
                    </option>
                    <option value="in-review" {{ $task->status === 'in-review' ? 'selected' : '' }}>
                        In Review
                    </option>
                    <option value="on-hold" {{ $task->status === 'on-hold' ? 'selected' : '' }}>
                        On hold
                    </option>

                </select>
            </div>
            @error('status')
                <div class="text-danger">{{ $message . '*' }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
    <p class="text-center text-primary"><small></small></p>
@endsection
