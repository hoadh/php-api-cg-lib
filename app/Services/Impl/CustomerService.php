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
        $customer->name = $request->name;
        $customer->group = $request->group;
        $customer->code = $request->code;
        $customer->address = $request->address;
        $role = $request->role;
        switch ($role) {
            case CustomerRoleConstants::ROLE_STUDENT:
                $customer->role = CustomerRoleConstants::ROLE_STUDENT;
                break;
            case CustomerRoleConstants::ROLE_TEACHER:
                $customer->role = CustomerRoleConstants::ROLE_TEACHER;
                break;
            default:
                $customer->role = CustomerRoleConstants::ROLE_OTHER;
                break;
        }
        $customer->library_id = $library_id;
        $customer->birthday = $request->birthday;
        $this->customerRepository->create($customer);
    }

    public function find($library_id, $customer_id)
    {
        return $this->customerRepository->findCustomer($library_id, $customer_id);
    }

    public function update($request, $customer)
    {
        $customer->name = $request->name;
        $customer->group = $request->group;
        $customer->code = $request->code;
        $customer->address = $request->address;
        $role = $request->role;
        switch ($role) {
            case CustomerRoleConstants::ROLE_STUDENT:
                $customer->role = CustomerRoleConstants::ROLE_STUDENT;
                break;
            case CustomerRoleConstants::ROLE_TEACHER:
                $customer->role = CustomerRoleConstants::ROLE_TEACHER;
                break;
            default:
                $customer->role = CustomerRoleConstants::ROLE_OTHER;
                break;
        }
        $customer->birthday = $request->birthday;
        $this->customerRepository->update($customer);
    }

    public function delete($customer_id) {
        $this->customerRepository->delete($customer_id);
    }
}
