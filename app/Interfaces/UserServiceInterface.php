<?php

namespace App\Interfaces;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    public function list();
    public function get(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function search(int $perPage, array $filters): LengthAwarePaginator;
}
