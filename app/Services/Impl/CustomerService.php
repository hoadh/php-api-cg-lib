<?php


namespace App\Services\Impl;


use App\Customer;
use App\Http\Controllers\CustomerRoleConstants;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Services\BaseService;
use App\Services\CustomerServiceInterface;

class CustomerService extends BaseService implements CustomerServiceInterface
{
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAll($library_id)
    {
        return $this->customerRepository->getCustomersByLibraryId($library_id);
    }

    public function create($request, $library_id)
    {
        $customer = new Customer();
        $customer->full_name = $request->full_name;
        $customer->department = $request->department;
        $customer->library_id = $library_id;
        return $this->customerRepository->create($customer);
    }

    public function find($library_id, $customer_id)
    {
        return $this->customerRepository->findCustomer($library_id, $customer_id);
    }

    public function update($request, $customer)
    {
        $customer->full_name = $request->full_name;
        $customer->department = $request->department;
        $this->customerRepository->update($customer);
    }

    public function delete($customer_id) {
        $this->customerRepository->delete($customer_id);
    }
}
