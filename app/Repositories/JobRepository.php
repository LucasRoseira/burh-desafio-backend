<?php

namespace App\Repositories;

use App\Models\Job;

class JobRepository
{
    protected $model;

    public function __construct(Job $job)
    {
        $this->model = $job;
    }

    public function all()
    {
        return $this->model->all();
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
        $job->update($data);
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
