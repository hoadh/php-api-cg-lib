<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateLibraryRequest;
use App\Http\Requests\Api\UpdateLibraryRequest;
use App\Services\LibraryServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class LibraryController extends Controller
{
    protected $libraryService;

    public function __construct(LibraryServiceInterface $libraryService)
    {
        $this->libraryService = $libraryService;
    }

    public function store(Request $request)
    {
        if (!$this->userCan('system-management')) {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized'], 403);
        }

        try {
            $this->libraryService->create($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.create_library_success')]);
    }

    public function index()
    {
        if (!$this->userCan('system-management')) {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized'], 403);
        }

        try {
            $libraries = $this->libraryService->getAll();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $libraries
        ], 200);
    }

    public function destroy($id)
    {
        if (!$this->userCan('system-management')) {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized'], 403);
        }

        try {
            $library = $this->libraryService->find($id);
            if (!$library) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_library')], 404);
            }

            $this->libraryService->delete($id);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.delete_library_success')
        ], 200);

    }

    public function update(UpdateLibraryRequest $request, $id)
    {
        if (!$this->userCan('system-management')) {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized'], 403);
        }

        try {
            $library = $this->libraryService->find($id);
            if (!$library) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_library')], 404);
            }

            $this->libraryService->update($request, $library);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.update_library_success')
        ], 200);

    }

    public function show($id)
    {
        if (!$this->userCan('system-management')) {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized'], 403);
        }

        try {
            $library = $this->libraryService->find($id);
            if (!$library) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_library')], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $library
        ], 200);
    }
}
