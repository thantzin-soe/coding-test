<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use TZS\LaravelRepositoryGenerator\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function paginate($size = 10): LengthAwarePaginator
    {
        return $this->model->where('id', '<>', auth('sanctum')->user()->id)->orderBy('id', 'desc')->paginate($size);
    }
}
