<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService implements UserServiceInterface
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function list(int $perPage = 10, int $page = 1): LengthAwarePaginator
    {
        return $this->repository->all($perPage, $page);
    }


    public function get(int $id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        $user = $this->repository->find($id);
        return $this->repository->update($user, $data);
    }

    public function delete(int $id)
    {
        $user = $this->repository->find($id);
        return $this->repository->delete($user);
    }

    public function search(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        return $this->repository->search($perPage, $filters);
    }

}
