<?php

namespace App\Interfaces;

use App\Models\Company;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CompanyRepositoryInterface
{
    public function all(int $perPage = 10, int $page = 1): LengthAwarePaginator;
    public function find(int $id);
    public function create(array $data);
    public function update(Company $company, array $data);
    public function delete(Company $company);
}
