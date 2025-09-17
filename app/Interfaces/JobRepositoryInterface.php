<?php

namespace App\Interfaces;

use App\Models\Job;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
interface JobRepositoryInterface
{
    public function all(int $perPage = 10, int $page = 1): LengthAwarePaginator;
    public function find(int $id);
    public function create(array $data);
    public function update(Job $job, array $data);
    public function delete(Job $job);
    public function countByCompany(int $companyId);
}
