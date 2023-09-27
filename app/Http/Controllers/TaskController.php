<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TaskUpdateRequest;

class TaskController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:task list|task create|task edit|task delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:task create', ['only' => ['create', 'store']]);
        $this->middleware('permission:task edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:task delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // $completed_tasks = Task::orderBy('id', 'DESC')->where('status', '=', 'completed')->with('user')->paginate(10);
        $tasks = Task::orderBy('id', 'DESC')->with('user')->paginate(10);
        $users = User::orderBy('id', 'DESC')->get();
        return view('tasks.index', compact('tasks', 'users'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function setStatus($task, $status)
    {
        $task = Task::find($task);
        $task->update([
            'status' => $status
        ]);
        return $task;
    }
    function setTaskReview($task_id, $status, $message)
    {
        return DB::table('task_reviews')->insert(['task_id' => $task_id, 'status' => $status, 'message' => $message, 'created_at' => now(), 'updated_at' => now()]);
    }

    public function create()
    {
        $users = User::get()->all();
        return view('tasks.create', compact('users'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->toArray());
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'type' => 'required',
            'deadline' => 'required',
            'priority' => 'required',
            'assigned_to' => 'nullable',
        ]);
        $data =
            [
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'deadline' => $request->deadline,
                'priority' => $request->priority,
                'creator' => Auth::id(),
            ];
        $task = task::create($data);
        $task->assigUser()->create(
            [
                'user_id' => $request->assigned_to,
            ]
        );

        return redirect()->route('tasks.index')->with('success', 'task created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        return view('tasks.show', compact('task'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = task::find($id);
        $users = User::get()->all();
        return view('tasks.edit', compact('task', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(TaskUpdateRequest $request, $id)
    {
        $request['assigned_to'] = intval($request->assigned_to);
        $data =
            [
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'deadline' => $request->deadline,
                'priority' => $request->priority,
                'status' =>  $request->status,
            ];

        $task = Task::find($id);
        $task->update($data);
        $task->assigUser()->update([
            'user_id' => $request->assigned_to
        ]);
        return redirect()->route('tasks.index')->with('success', 'task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getUserTask($user_id)
    {
        $user = User::find($user_id);
        $tasks = $user->tasks()->get();
        return $tasks;
    }
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        $task->assigUser()->delete($id);
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}
