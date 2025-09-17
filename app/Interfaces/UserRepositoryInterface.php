<?php

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\User;

interface UserRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(User $user, array $data);
    public function delete(User $user);
    public function search(int $perPage = 10, array $filters = []): LengthAwarePaginator;
}
