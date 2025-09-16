<?php

namespace App\Services;

use App\Models\Company;
use App\Interfaces\CompanyRepositoryInterface;
use App\Interfaces\CompanyServiceInterface;

class CompanyService implements CompanyServiceInterface
{
    protected $repository;

    public function __construct(CompanyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return $this->repository->all();
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
        $company = $this->repository->find($id);
        return $this->repository->update($company, $data);
    }

    public function delete(int $id)
    {
        $company = $this->repository->find($id);
        return $this->repository->delete($company);
    }
}
