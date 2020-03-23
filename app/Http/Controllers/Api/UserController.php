<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\CreateUserRequest;
use App\Services\UserServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        try {
            $this->userService->changePassword($user, $request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.change_password_success')]);
    }

    public function index()
    {
        if (!$this->userCan('system-management')) {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized'], 403);
        }

        try {
            $librarians = $this->userService->getLibrarians();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $librarians
        ], 200);
    }

    public function store(CreateUserRequest $request)
    {
        if (!$this->userCan('system-management')) {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized'], 403);
        }

        try {
            $this->userService->create($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.create_user_success')]);
    }

    public function destroy($id)
    {
        if (!$this->userCan('system-management')) {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized'], 403);
        }

        try {
            $user = $this->userService->find($id);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_user')], 404);
            }

            if ($this->userService->isAdmin($user)) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_delete_user')], 403);
            }

            $this->userService->delete($user->id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.delete_user_success')]);
    }

    public function update(Request $request, $id)
    {
        if (!$this->userCan('system-management')) {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized'], 403);
        }

        try {
            $user = $this->userService->find($id);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_user')], 404);
            }

            $this->userService->update($request, $user);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.update_user_success')]);

    }

    public function show($id)
    {
        if (!$this->userCan('system-management')) {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized'], 403);
        }

        try {
            $user = $this->userService->find($id);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_user')], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
}
