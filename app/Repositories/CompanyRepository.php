<?php

namespace App\Repositories;

use App\Models\Company;
use App\Interfaces\CompanyRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CompanyRepository implements CompanyRepositoryInterface
{
    protected $model;

    public function __construct(Company $company)
    {
        $this->model = $company;
    }

    public function all(int $perPage = 10, int $page = 1): LengthAwarePaginator
    {
        return $this->model->orderBy('name')->paginate($perPage, ['*'], 'page', $page);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Company $company, array $data)
    {
        $company->fill($data);
        $company->save();
        return $company;
    }

    public function delete(Company $company)
    {
        return $company->delete();
    }
}
