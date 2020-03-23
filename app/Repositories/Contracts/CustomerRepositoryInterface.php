<?php


namespace App\Repositories\Contracts;


interface CustomerRepositoryInterface
{
    public function getCustomersByLibraryId($library_id);
    public function findCustomer($library_id, $customer_id);
}
