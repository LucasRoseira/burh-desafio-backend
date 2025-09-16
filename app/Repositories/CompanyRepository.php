<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    protected $model;

    public function __construct(Company $company)
    {
        $this->model = $company;
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

    public function update(Company $company, array $data)
    {
        $company->update($data);
        return $company;
    }

    public function delete(Company $company)
    {
        return $company->delete();
    }
}
