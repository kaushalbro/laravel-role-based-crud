@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Activity</h2>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th>Created At</th>
        </tr>
        @foreach ($activity as $activity_log)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $activity_log->log_name }}</td>
                <td>{{ $activity_log->description }}</td>
                <td>{{ $activity_log->created_at->diffForHumans() }}</td>
            </tr>
        @endforeach
    </table>
    {!! $activity->links() !!}
@endsection
