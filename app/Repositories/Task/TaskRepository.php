<?php

namespace App\Repositories\Task;

use App\Models\Task;
use App\Repositories\Task\TaskRepositoryInterface;
use TZS\LaravelRepositoryGenerator\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class TaskRepository.
 */
class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Task $model
     */
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    public function paginate($size = 10): LengthAwarePaginator
    {
        return $this->model->orderBy('id', 'desc')->paginate($size);
    }

    public function markDone($id): bool
    {
        $task = $this->find($id);
        $task->update(['done' => true]);
        return true;
    }
}
