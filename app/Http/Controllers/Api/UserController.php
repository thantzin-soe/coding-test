<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\Api\UserStoreRequest;
use App\Http\Requests\Api\UserUpdateRequest;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware(['role:Admin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Response::collection(UserResource::collection($this->userRepository->paginate(10)));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        return Response::success(
            new UserResource($this->userRepository->create($request->validated())),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Response::success(
            new UserResource($this->userRepository->find($id)),
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $this->userRepository->update($id, $request->validated());
        return Response::success(
            new UserResource($this->userRepository->find($id)),
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userRepository->delete($id);

        return Response::success([
            'message' => 'Successfully deleted.',
        ]);
    }
}
