<?php


namespace App\Services;


interface CustomerServiceInterface
{
    public function getAll($library_id);
    public function create($request, $library_id);
    public function find($library_id, $customer_id);
    public function update($request, $customer);
}
