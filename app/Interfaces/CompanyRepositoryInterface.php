<?php

namespace App\Interfaces;

use App\Models\Company;

interface CompanyRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(Company $company, array $data);
    public function delete(Company $company);
}
