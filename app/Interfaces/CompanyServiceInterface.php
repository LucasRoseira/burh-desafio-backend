<?php

namespace App\Interfaces;

interface CompanyServiceInterface
{
    public function list();
    public function get(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
