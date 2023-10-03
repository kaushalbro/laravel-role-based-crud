@extends('layouts.app')
@section('content')
    @push('style')
        <style>
            .login_data,
            .modal-header,
            .modal-footer {
                background-color: #858686;
            }

            .modal-dialog {
                border-radius: 20px;
            }

            #feedback_input {
                border-radius: 10px;
                height: 30px;
                width: 200px;
                color: white;
                background-color: #858686;
                border: 1px solid white;
            }

            .feedback_input_container,
            #feedback_validation {
                display: flex;
                justify-content: center;
            }

            #feedBackForm_id {
                background-color: #858686;
            }

            #btn_rejection_submit {
                padding: 5px;
                border-radius: 20px;
                margin-left: 5px;
                margin-top: -2px;
            }
        </style>
    @endpush
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="login_data">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- for feedback --}}

    <!-- Button trigger modal -->
    <button id="btn_get_feedBack" type="button" hidden class="btn btn-primary" data-bs-toggle="modal"
        data-bs-target="#feedBackForm">
    </button>

    <!-- Modal -->
    <div class="modal fade" id="feedBackForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div id="feedBackForm_id" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Rejection Reason / Note</h5>
                </div>
                <div class="feedback_input_container p-2">
                    <label for="feedback" class="text-white mt-1 me-2">Message: </label>
                    <textarea name="feedback" id="feedback_input"></textarea>
                    <button onclick="rejectedReason()" id="btn_rejection_submit" class="btn btn-primary">Submit</button>
                </div>
                <p id="feedback_validation" class="text-danger text-center"></p>
                <div class="modal-footer">
                    <button id="btn_close_feedback" type="button" class="btn btn-secondary" hidden
                        data-bs-dismiss="modal"></button>
                    {{-- <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button> --}}
                </div>
            </div>
        </div>
    </div>
    @can('task create')
        <!-- Button trigger modal -->
        <!-- Modal -->
        <div class="row">
            <div class="col-lg-12 margin-tb ">
                <div class="pull-left">
                    <h2 class="text-white">Task Management</h2>
                </div>
                <a class="btn btn-primary mb-2" href="{{ route('tasks.create') }}"> Create New Tasks</a>
                <button id="create_task" type="button" onclick="getTaskcreatePage('/tasks/create','GET')"
                    class="mb-2 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Create Task
                </button>
                <div class="pull-right user_container">
                    <div class="user_lists d-flex mb-1">
                        <form action="#" method="post">
                            <input type="text" name="user_search" class="user_search me-1" placeholder='Search user'>
                        </form>

                        <div class="user_list">
                            @if (count($users) > 0)
                                @foreach ($users as $user)
                                    <a href="#" class="user_name "
                                        onclick="getUserTask('/user/{{ $user->id }}/tasks','GET','{{ $user->name }}')"
                                        title="{{ $user->name }}">
                                        {{ strtoupper($user->name[0]) . $user->name[1] }}
                                    </a>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="task_main_container">
        {{-- todo task --}}
        <div class="todo_task_container task_container">
            <h6 class="container_heading todo_heading">TO DO ( <span id="todo_task_count"></span> )</h6>
            <hr class="_hr">
            <div id="todo_task" class="column task_list todo-task" data-container="todo_tasks" ondrop="drop(event)"
                ondragover="allowDrop(event)">
                @foreach ($tasks as $key => $task)
                    @if ($task->status == 'pending' && (Auth::user()->hasRole('Admin') || $task->user->id === Auth::id()))
                        <div id="taskk" class="task {{ $task->id }}" draggable="true" ondragstart="drag(event)"
                            data-id="{{ $task->id }}">
                            <div class="task_data">
                                <p class="task_name">{{ $task->name }}</p>
                            </div>
                            <div class="task_action">
                                @if ($task->priority === 'high')
                                    <i class="fa-solid fa-angles-up text-danger" title="High Priority"></i>
                                @elseif ($task->priority === 'medium')
                                    <i class="fa-solid fa-angles-up text-warning" title="Medium Priority"></i>
                                @elseif ($task->priority === 'low')
                                    <i class="fa-solid fa-angles-down text-primary" title="Low Priority"></i>
                                @endif
                                <i id="create_task" onclick="getTaskcreatePage('/tasks/'+{{ $task->id }},'GET')"
                                    class="fa-regular fa-eye" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
                                @can('task create', 'task delete')
                                    <i onclick="requestHttp('/tasks/'+{{ $task->id }} + '/edit','GET')"
                                        class="fa-solid fa-pen-to-square"></i>
                                    <i onclick="requestHttp('/tasks/'+{{ $task->id }},'DELETE')"
                                        class="fa-solid fa-trash"></i>
                                @endcan
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        {{-- in progress task --}}
        <div class="inprogress_task_container task_container">
            <h6 class="container_heading in_progress_heading">IN PROGRESS ( <span id="in_progress_task_count"></span> )
            </h6>
            <hr class="_hr">
            <div id="inprogress_tasks" class="column task_list in-progress-task" data-container="inprogress_tasks"
                ondrop="drop(event)" ondragover="allowDrop(event)">
                @foreach ($tasks as $key => $task)
                    @if ($task->status == 'in-progress' && (Auth::user()->hasRole('Admin') || $task->user->id === Auth::id()))
                        <div id="in_progress_tasks" class="task {{ $task->id }}" draggable="true"
                            ondragstart="drag(event)" data-id="{{ $task->id }}">
                            <div class="task_data">
                                <p class="task_name">{{ $task->name }}</p>
                            </div>
                            <div class="task_action">
                                @if ($task->priority === 'high')
                                    <i class="fa-solid fa-angles-up text-danger" title="High Priority"></i>
                                @elseif ($task->priority === 'medium')
                                    <i class="fa-solid fa-angles-up text-warning" title="Medium Priority"></i>
                                @elseif ($task->priority === 'low')
                                    <i class="fa-solid fa-angles-down text-primary" title="Low Priority"></i>
                                @endif
                                <i id="create_task" onclick="getTaskcreatePage('/tasks/'+{{ $task->id }},'GET')"
                                    class="fa-regular fa-eye" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
                                @can('task create', 'task delete')
                                    <i onclick="requestHttp('/tasks/'+{{ $task->id }} + '/edit','GET')"
                                        class="fa-solid fa-pen-to-square"></i>
                                    <i onclick="requestHttp('/tasks/'+{{ $task->id }},'DELETE')"
                                        class="fa-solid fa-trash"></i>
                                @endcan
                            </div>

                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        {{-- completed task --}}
        <div class="completed_task_container task_container">
            <h6 class="container_heading completed_heading">COMPLETED ( <span id="completed_task_count"></span> )</h6>
            <hr class="_hr">
            <div id="completed_task" class="column task_list completed-task" data-container="completed_tasks"
                ondrop="drop(event)" ondragover="allowDrop(event)">
                @foreach ($tasks as $key => $task)
                    @if ($task->status == 'completed' && (Auth::user()->hasRole('Admin') || $task->user->id === Auth::id()))
                        <div id="completed_tasks" class="task {{ $task->id }}" draggable="true"
                            ondragstart="drag(event)" data-id="{{ $task->id }}">
                            <div class="task_data">
                                <p class="task_name">{{ $task->name }}</p>
                            </div>
                            <div class="task_action">
                                @if ($task->priority === 'high')
                                    <i class="fa-solid fa-angles-up text-danger" title="High Priority"></i>
                                @elseif ($task->priority === 'medium')
                                    <i class="fa-solid fa-angles-up text-warning" title="Medium Priority"></i>
                                @elseif ($task->priority === 'low')
                                    <i class="fa-solid fa-angles-down text-primary" title="Low Priority"></i>
                                @endif
                                <i id="create_task" onclick="getTaskcreatePage('/tasks/'+{{ $task->id }},'GET')"
                                    class="fa-regular fa-eye" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
                                @can('task create', 'task delete')
                                    <i onclick="requestHttp('/tasks/'+{{ $task->id }} + '/edit','GET')"
                                        class="fa-solid fa-pen-to-square"></i>
                                    <i onclick="requestHttp('/tasks/'+{{ $task->id }},'DELETE')"
                                        class="fa-solid fa-trash"></i>
                                @endcan
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        {{-- inreview task --}}
        <div class="in_review_task_container task_container">
            <h6 class="container_heading inreview_heading">In Review ( <span id="in_review_task_count"></span> )</h6>
            <hr class="_hr">
            <div id="in_review_tasks" class="column task_list in-review-task" data-container="in_review_tasks"
                {{ Auth::user()->hasRole('Admin') ? 'ondrop=drop(event) ondragover=allowDrop(event)' : '' }}>
                @foreach ($tasks as $key => $task)
                    @if ($task->status == 'in-review' && (Auth::user()->hasRole('Admin') || $task->user->id === Auth::id()))
                        <div id="in_review_task" class="task {{ $task->id }}"
                            {{ Auth::user()->hasRole('Admin') ? 'draggable=true ondragstart=drag(event)' : '' }}
                            data-id="{{ $task->id }}">
                            <div class="task_data">
                                <p class="task_name">{{ $task->name }}</p>
                            </div>
                            <div class="task_action">
                                @if ($task->priority === 'high')
                                    <i class="fa-solid fa-angles-up text-danger" title="High Priority"></i>
                                @elseif ($task->priority === 'medium')
                                    <i class="fa-solid fa-angles-up text-warning" title="Medium Priority"></i>
                                @elseif ($task->priority === 'low')
                                    <i class="fa-solid fa-angles-down text-primary" title="Low Priority"></i>
                                @endif
                                <i id="create_task" onclick="getTaskcreatePage('/tasks/'+{{ $task->id }},'GET')"
                                    class="fa-regular fa-eye" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
                                @can('task create', 'task delete')
                                    <i onclick="requestHttp('/tasks/'+{{ $task->id }} + '/edit','GET')"
                                        class="fa-solid fa-pen-to-square"></i>
                                    <i onclick="requestHttp('/tasks/'+{{ $task->id }},'DELETE')"
                                        class="fa-solid fa-trash"></i>
                                @endcan
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        {{-- rejected task --}}
        <div class="rejected_task_container task_container">
            <h6 class="container_heading rejected_heading">Rejected Task ( <span id="rejected_task_count"></span> )</h6>
            <hr class="_hr">
            <div id="rejected_tasks" class="column task_list rejected-task" data-container="rejected_tasks"
                {{ Auth::user()->hasRole('Admin') ? 'ondrop=drop(event) ondragover=allowDrop(event)' : '' }}>
                @foreach ($tasks as $key => $task)
                    @if ($task->status == 'rejected' && (Auth::user()->hasRole('Admin') || $task->user->id === Auth::id()))
                        <div id="in_review_task" class="task {{ $task->id }}"
                            {{ Auth::user()->hasRole('Admin') ? 'draggable=true ondragstart=drag(event)' : '' }}
                            data-id="{{ $task->id }}">
                            <div class="task_data">
                                <p class="task_name">{{ $task->name }}</p>
                            </div>
                            <div class="task_action">
                                @if ($task->priority === 'high')
                                    <i class="fa-solid fa-angles-up text-danger" title="High Priority"></i>
                                @elseif ($task->priority === 'medium')
                                    <i class="fa-solid fa-angles-up text-warning" title="Medium Priority"></i>
                                @elseif ($task->priority === 'low')
                                    <i class="fa-solid fa-angles-down text-primary" title="Low Priority"></i>
                                @endif
                                <i id="create_task" onclick="getTaskcreatePage('/tasks/'+{{ $task->id }},'GET')"
                                    class="fa-regular fa-eye" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
                                @can('task create', 'task delete')
                                    <i onclick="requestHttp('/tasks/'+{{ $task->id }} + '/edit','GET')"
                                        class="fa-solid fa-pen-to-square"></i>
                                    <i onclick="requestHttp('/tasks/'+{{ $task->id }},'DELETE')"
                                        class="fa-solid fa-trash"></i>
                                @endcan
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        {{-- main ending --}}
    </div>

    {{-- function individual_task(task) {
        return `<div class="task {{ $task->id }}" draggable="true" ondragstart="drag(event)"
    data-id="{{ $task->id }}">
    <div class="task_data">
        <p class="task_name">{{ $task->name }}</p>
    </div>
    <div class="task_action">
        @if ($task->priority === 'high')
            <i class="fa-solid fa-angles-up text-danger" title="High Priority"></i>
        @elseif ($task->priority === 'medium')
            <i class="fa-solid fa-angles-up text-warning" title="Medium Priority"></i>
        @elseif ($task->priority === 'low')
            <i class="fa-solid fa-angles-down text-primary" title="Low Priority"></i>
        @endif
        <i id="create_task" onclick="getTaskcreatePage('/tasks/'+{{ $task->id }},'GET')"  class="fa-regular fa-eye" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
        @can('task create', 'task delete')
            <i onclick="requestHttp('/tasks/'+{{ $task->id }} + '/edit','GET')"
                class="fa-solid fa-pen-to-square"></i>
            <i onclick="requestHttp('/tasks/'+{{ $task->id }},'DELETE')"
                class="fa-solid fa-trash"></i>
        @endcan
    </div>
</div>`
    }           --}}

    <p class="text-center text-primary"><small></small></p>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>description</th>
            <th>Assigned to</th>
            <th>Status</th>
            <th>Type</th>
            <th>deadline</th>
            <th>created_at</th>
            <th>updated_at</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($tasks as $key => $task)
            @php
                $deadline = \Carbon\Carbon::parse($task->deadline);
            @endphp
            @if (Auth::user()->hasRole('Admin') || $task->user->id === Auth::id())
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->description }}</td>
                    <td>
                        @if (isset($task->user))
                            {{ $task->user->name }}
                        @else
                            <p class="text-danger">Not Assigned</p>
                        @endif
                    </td>
                    {{-- @dd($task->user->name) --}}
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->type }}</td>
                    <td>{{ $task->created_at }}</td>
                    <td>{{ $task->updated_at }}</td>
                    <td class='{{ $deadline->isFuture() == null ? 'text-danger' : '' }}'>
                        {{ $deadline->isFuture() == null ? 'Expired' : $deadline }} <br>
                        ({{ $deadline->diffForHumans(null, false, true) }})
                    </td>
                    <td>
                        <a class="btn btn-info" href="{{ route('tasks.show', $task->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['tasks.destroy', $task->id], 'style' => 'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endif
        @endforeach
    </table>
    {!! $tasks->render() !!}
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            // Listen for a click event on the search input field
            $(".user_search").click(function() {
                // Perform a search when the input field is clicked
                // searchDatabase();
                $(".user_dropdown").css({
                    "display": "block",
                });
            });
        });
    </script>

    <script>
        function getTaskcreatePage(url_, method) {
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: url_,
                type: method,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function(data) {
                    $('.login_data').html(data);
                },
                error: function(data) {
                    console.log('error: ' + data);
                }
            });
        }
    </script>
    <script>
        updateTask_count();

        function individual_task(task) {
            return `<div class="task {{ $task->id }}" draggable="true" ondragstart="drag(event)"
    data-id="{{ $task->id }}">
    <div class="task_data">
        <p class="task_name">{{ $task->name }}</p>
    </div>
    <div class="task_action">
        @if ($task->priority === 'high')
            <i class="fa-solid fa-angles-up text-danger" title="High Priority"></i>
        @elseif ($task->priority === 'medium')
            <i class="fa-solid fa-angles-up text-warning" title="Medium Priority"></i>
        @elseif ($task->priority === 'low')
            <i class="fa-solid fa-angles-down text-primary" title="Low Priority"></i>
        @endif
        <i id="create_task" onclick="getTaskcreatePage('/tasks/'+{{ $task->id }},'GET')"  class="fa-regular fa-eye" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
        @can('task create', 'task delete')
            <i onclick="requestHttp('/tasks/'+{{ $task->id }} + '/edit','GET')"
                class="fa-solid fa-pen-to-square"></i>
            <i onclick="requestHttp('/tasks/'+{{ $task->id }},'DELETE')"
                class="fa-solid fa-trash"></i>
        @endcan
    </div>
</div>`
        }

        function updateTask_count() {
            var total_length_todo = $("#todo_task").children().length;
            var total_length_in_progress = $("#inprogress_tasks").children().length;
            var total_length_completed = $("#completed_task").children().length;
            var in_review_task = $("#in_review_tasks").children().length;
            var rejected_tasks = $("#rejected_tasks").children().length;
            $('#todo_task_count').text(total_length_todo);
            $('#in_progress_task_count').text(total_length_in_progress);
            $('#completed_task_count').text(total_length_completed);
            $('#in_review_task_count').text(in_review_task);
            $('#rejected_task_count').text(rejected_tasks);
        }
        const allowDrop = (event) => {
            event.preventDefault();
        };
        const dragStart = (event) => {
            event.currentTarget.classList.add("dragging");
        };
        const dragEnd = (event) => {
            event.currentTarget.classList.remove("dragging");
        };
        // when drag starts add dragging class and remove when ends drag.
        document.querySelectorAll(".task").forEach((task) => {
            task.addEventListener("dragstart", dragStart);
            task.addEventListener("dragend", dragEnd);
        });
        const drag = (event) => {
            event.dataTransfer.setData("text/html", event.currentTarget.outerHTML);
            event.dataTransfer.setData("text/plain", event.currentTarget.dataset.id);
            event.dataTransfer.setData("text/container", event.currentTarget.parentElement.getAttribute(
                'data-container'));
        };

        const dragEnter = (event) => {
            event.currentTarget.classList.add("drop");
        };
        const dragLeave = (event) => {
            event.currentTarget.classList.remove("drop");
        };
        document.querySelectorAll(".column").forEach((column) => {
            column.addEventListener("dragenter", dragEnter);
            column.addEventListener("dragleave", dragLeave);
        });
        let rejected_task_id;
        const drop = (event) => {
            var draggedFrom = event.dataTransfer.getData("text/container");
            var dropTo = event.currentTarget.getAttribute('data-container');
            var task_id = event.dataTransfer.getData("text/plain");
            document
                .querySelectorAll(".column")
                .forEach((column) => column.classList.remove("drop"));
            document
                .querySelector(`[data-id="${event.dataTransfer.getData("text/plain")}"]`)
                .remove();
            event.currentTarget.innerHTML =
                event.currentTarget.innerHTML + event.dataTransfer.getData("text/html");

            if (dropTo === 'todo_tasks' && (dropTo != draggedFrom)) {
                sendAndsetStatus(task_id, 'pending');
            } else if (dropTo === 'in_review_tasks' && (dropTo != draggedFrom)) {
                sendAndsetStatus(task_id, 'in-review');
            } else if (dropTo === 'completed_tasks' && (dropTo != draggedFrom)) {
                sendAndsetStatus(task_id, 'completed');
            } else if (dropTo === 'inprogress_tasks' && (dropTo != draggedFrom)) {
                sendAndsetStatus(task_id, 'in-progress');
            } else if (dropTo === 'rejected_tasks' && (dropTo != draggedFrom)) {
                $('#btn_get_feedBack').click();
                document.getElementById('feedback_input').value = '';
                rejected_task_id = task_id;
            }
        };

        function rejectedReason() {
            result = document.getElementById('feedback_input').value;
            if (result == '') {
                $('#feedback_validation').text('This field cannot be empty.');
                return '';
            } else {
                var status = 'rejected';
                if (rejected_task_id) {
                    sendAndsetStatus(rejected_task_id, 'rejected')
                        .then((response) => {
                            if (response) {
                                requestHttp('/task_review/' + rejected_task_id + '/' + status + '/message=' + result,
                                    'POST');
                            }
                        })
                        .catch((error) => {
                            reject(error)
                        });
                }
                $('#btn_close_feedback').click();
                $('#feedback_validation').text('');

            }
        }

        function sendAndsetStatus(task_id, status) {
            return new Promise((resolve, reject) => {
                requestHttp('/update_task/' + task_id + '/' + status, 'PATCH')
                    .then((successMessage) => {
                        resolve(successMessage);
                    })
                    .catch((error) => {
                        reject(error)
                    });
            })
        }

        function getUserTask(url_, method, user_name) {
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: url_,
                type: method,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function(data) {

                    // 

                    $('#indivisual_user_name').text("Task's of: " + user_name);
                    const pendingTasks = data.filter(function(task) {
                        return task.status === 'pending';
                    });
                    const completedTask = data.filter(function(task) {
                        return task.status === 'completed';
                    });
                    const in_progress_task = data.filter(function(task) {
                        return task.status === 'in-progress';
                    });
                    const in_review_tasks = data.filter(function(task) {
                        return task.status === 'in-review';
                    });
                    const rejected_tasks = data.filter(function(task) {
                        return task.status === 'rejected';
                    });
                    // console.log(rejected_tasks);
                    
                    $("#todo_task").empty();
                    $("#inprogress_tasks").empty();
                    $("#completed_task").empty();
                    $("#in_review_tasks").empty();
                    $("#rejected_tasks").empty();

                    pendingTasks.forEach(task => {
                        if (task) {
                            $('#todo_task').append(individual_task(task));
                        }
                    });
                    completedTask.forEach(task => {
                        if (task) {
                            $('#completed_task').append(individual_task(task));
                        }
                    });
                    in_progress_task.forEach(task => {
                        if (task) {
                            $('#inprogress_tasks').append(individual_task(task));

                        }
                    });
                    in_review_tasks.forEach(task => {
                        if (task) {
                            $('#in_review_tasks').append(individual_task(task));

                        }
                    });
                    rejected_tasks.forEach(task => {
                        if (task) {
                            $('#rejected_tasks').append(individual_task(task));
                        }
                    });
                    updateTask_count();
                },
                error: function(data) {
                    console.log('error: ' + data);
                }
            });
        }

        function requestHttp(url_, method) {
            return new Promise((resolve, reject) => {
                var token = $('meta[name="csrf-token"]').attr('content');
                if (method === 'GET' || method === 'get') {
                    location.href = url_;
                }
                $.ajax({
                    url: url_,
                    type: method,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function(data, b) {
                        updateTask_count();
                        console.log(data, b);
                        resolve(b);


                    },
                    error: function(error, textStatus, errorThrown) {
                        reject(errorThrown);
                    }
                });
            });
        }
    </script>
@endpush
