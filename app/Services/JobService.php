<?php

namespace App\Services;

use App\Models\Job;
use App\Interfaces\JobRepositoryInterface;
use App\Interfaces\JobServiceInterface;
use App\Models\Company;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class JobService implements JobServiceInterface
{
    protected $repository;

    public function __construct(JobRepositoryInterface $repository)
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
        $company = Company::find($data['company_id']);
        $maxJobs = $company->plan === 'Free' ? 5 : 10;

        if ($this->repository->countByCompany($company->id) >= $maxJobs) {
            throw new \Exception("This company has reached the maximum number of jobs for its plan.");
        }

        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        $job = $this->repository->find($id);
        return $this->repository->update($job, $data);
    }

    public function delete(int $id)
    {
        $job = $this->repository->find($id);
        return $this->repository->delete($job);
    }
}
