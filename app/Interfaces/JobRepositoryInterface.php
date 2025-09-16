<?php

namespace App\Interfaces;

use App\Models\Job;

interface JobRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(Job $job, array $data);
    public function delete(Job $job);
    public function countByCompany(int $companyId);
}
