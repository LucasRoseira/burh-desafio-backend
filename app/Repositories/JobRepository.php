<?php

namespace App\Repositories;

use App\Models\Job;
use App\Interfaces\JobRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class JobRepository implements JobRepositoryInterface
{
    protected $model;

    public function __construct(Job $job)
    {
        $this->model = $job;
    }

    public function all(int $perPage = 10, int $page = 1): LengthAwarePaginator
    {
        return $this->model->paginate($perPage, ['*'], 'page', $page);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Job $job, array $data)
    {
        $job->fill($data);
        $job->save();
        return $job;
    }

    public function delete(Job $job)
    {
        return $job->delete();
    }

    public function countByCompany(int $companyId)
    {
        return $this->model->where('company_id', $companyId)->count();
    }
}
