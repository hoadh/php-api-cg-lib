<?php

namespace App\Http\Controllers\Api;

use App\Services\CustomerServiceInterface;
use App\Services\LibraryServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    protected $customerService;
    protected $libraryService;

    public function __construct(CustomerServiceInterface $customerService,
                                LibraryServiceInterface $libraryService)
    {
        $this->customerService = $customerService;
        $this->libraryService = $libraryService;
    }

    public function index($library_id)
    {
        try {
            $library = $this->libraryService->find($library_id);
            if (!$library) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('can_not_find_library')
                ], 404);
            }

            $customers = $this->customerService->getAll($library_id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $customers
        ], 200);
    }

    public function store(Request $request, $library_id)
    {
        try {
            $library = $this->libraryService->find($library_id);
            if (!$library) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('can_not_find_library')
                ], 404);
            }

            $this->customerService->create($request, $library_id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.create_customer_success')
        ], 200);
    }

    public function show($library_id, $customer_id)
    {
        try {
            $library = $this->libraryService->find($library_id);
            if (!$library) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('can_not_find_library')
                ], 404);
            }

            $customer = $this->customerService->find($library_id, $customer_id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $customer
        ], 200);
    }

    public function update(Request $request, $library_id, $customer_id)
    {
        try {
            $library = $this->libraryService->find($library_id);
            if (!$library) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('can_not_find_library')
                ], 404);
            }

            $customer = $this->customerService->find($library_id, $customer_id);
            if (!$customer) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('can_not_find_customer')
                ], 404);
            }

            $this->customerService->update($request, $customer);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.update_customer_success')
        ], 200);

    }

    public function delete($libraryId, $customerId)
    {
        try {
            $customer = $this->customerService->find($libraryId, $customerId);
            if (!$customer) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_customer')
                ], 500);
            }
            $this->customerService->delete($customer->id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.delete_customer_success')
        ], 200);
    }
}
