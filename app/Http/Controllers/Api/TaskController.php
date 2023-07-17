<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Task\TaskRepositoryInterface;
use App\Http\Requests\Api\TaskStoreRequest;
use App\Http\Requests\Api\TaskUpdateRequest;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\TaskResource;
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
        return Response::collection(TaskResource::collection($this->taskRepository->paginate(10)));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        return Response::success(
            new TaskResource($this->taskRepository->create($request->validated())),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Response::success(
            new TaskResource($this->taskRepository->find($id)),
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, string $id)
    {
        $this->taskRepository->update($id, $request->validated());
        return Response::success(
            new TaskResource($this->taskRepository->find($id)),
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->taskRepository->delete($id);

        return Response::success([
            'message' => 'Successfully deleted.',
        ]);
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

        return Response::success();
    }
}
