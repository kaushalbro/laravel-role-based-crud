@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Task</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('tasks.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $task->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                {{ $task->description }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Creator:</strong>
                {{ $task->creator }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                {{$task}}
                @if (count($task->task_reviews) > 0)
                    {{-- {{$task->task_reviews}} --}}
                    @foreach ($task->task_reviews as $review)
                        @if ($review->status == 'rejected')
                            <strong>Rejection :</strong>
                            {{ $review->message }} : rejected on {{ $review->created_at }}<br>
                        @endif
                    @endforeach
                @endif

            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Assigned to:</strong>
                @if (isset($task->user))
                    {{ $task->user->name }}
                @else
                    <p class="text-danger">Not Assigned</p>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>status:</strong>
                {{ $task->status }}
            </div>
        </div>
    </div>
@endsection
