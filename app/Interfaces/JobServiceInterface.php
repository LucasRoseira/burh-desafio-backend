<?php

namespace App\Interfaces;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface JobServiceInterface
{
    public function list(int $perPage = 10, int $page = 1): LengthAwarePaginator;
    public function get(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
