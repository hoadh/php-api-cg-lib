<?php

namespace App\Http\Controllers\Api;

use App\Services\BorrowServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BorrowController extends Controller
{
    protected $borrowService;

    public function __construct(BorrowServiceInterface $borrowService)
    {
        $this->borrowService = $borrowService;
    }

    public function store(Request $request, $lib_id)
    {
        try {
            $this->borrowService->create($request, $lib_id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.create_borrow_success')
        ], 200);
    }

    public function index($lib_id)
    {
        try {
            $borrows = $this->borrowService->getAll($lib_id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $borrows
        ], 200);
    }

    public function show($lib_id, $borrow_id)
    {
        try {
            $borrow = $this->borrowService->findByLibraryId($lib_id, $borrow_id);
            if (!$borrow) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_borrow')
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $borrow
        ], 200);
    }

    public function update(Request $request, $lib_id, $borrow_id)
    {
        try {
            $borrow = $this->borrowService->findByLibraryId($lib_id, $borrow_id);
            if (!$borrow) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_borrow')
                ], 500);
            }
            $this->borrowService->update($borrow, $request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.update_borrow_success')
        ], 200);
    }

    public function filter(Request $request) {
        try {
            $stat = $this->borrowService->getCountBorrows($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $stat
        ], 200);
    }
}
