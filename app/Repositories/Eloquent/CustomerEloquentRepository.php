<?php


namespace App\Repositories\Eloquent;


use App\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;

class CustomerEloquentRepository extends EloquentRepository implements CustomerRepositoryInterface
{

    /**
     * get Model
     * @return string
     */
    public function getModel()
    {
        return Customer::class;
    }

    public function getCustomersByLibraryId($library_id)
    {
        return Customer::where('library_id', $library_id)->get();
    }

    public function findCustomer($library_id, $customer_id)
    {
        return Customer::where('library_id', $library_id)->find($customer_id);
    }
}
