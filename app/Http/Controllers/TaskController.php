<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Repositories\Task\TaskRepositoryInterface;
use App\Http\Requests\Api\TaskStoreRequest;
use App\Http\Requests\Api\TaskUpdateRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class TaskController extends Controller
{
    private $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->middleware(['permission:create-tasks|edit-tasks|delete-tasks'])->except(['index', 'show', 'markDone']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::orderBy('id', 'desc')->paginate(10);
        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        $task = $this->taskRepository->create($request->validated());

        $notification = [
            'message' => 'Task added successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('tasks.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = $this->taskRepository->find($id);
        return view('task.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, string $id)
    {
        $this->taskRepository->update($id, $request->validated());
        $task = $this->taskRepository->find($id);

        $notification = [
            'message' => 'Task updated successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('tasks.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->taskRepository->delete($id);

        $notification = [
            'message' => 'Task deleted successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('tasks.index')->with($notification);
    }

    public function markDone(string $id)
    {
        $task = $this->taskRepository->find($id);

        if (!auth('sanctum')->user()->hasAnyRole('Admin', 'Manager')) {
            if (! Gate::allows('mark-done', $task)) {
                throw new AuthorizationException();
            }
        }

        $this->taskRepository->markDone($task->id);

        $notification = [
            'message' => 'Task done successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('tasks.index')->with($notification);
    }
}
