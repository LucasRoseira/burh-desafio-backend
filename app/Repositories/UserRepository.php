<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function all(int $perPage = 10, int $page = 1): LengthAwarePaginator
    {
        return $this->model->paginate($perPage, ['*'], 'page', $page);
    }

    public function find(int $id)
    {
        return $this->model->with('jobs')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(User $user, array $data)
    {
        $user->fill($data);
        $user->save();
        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    public function search(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->with('jobs');

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }

        if (!empty($filters['cpf'])) {
            $query->where('cpf', $filters['cpf']);
        }

        return $query->orderBy('name')->paginate($perPage);
    }
}
