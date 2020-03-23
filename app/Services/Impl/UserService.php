<?php


namespace App\Services\Impl;


use App\Http\Controllers\RoleConstants;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\BaseService;
use App\Services\UserServiceInterface;
use App\User;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UserService extends BaseService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        $users = $this->userRepository->getAll();
        return $users;
    }

    public function changePassword($user, $request)
    {
        $hashedPassword = $user->password;

        $passOld = $request->input('pw_old');
        $passNew = $request->input('pw_new');

        if (!Hash::check($passOld, $hashedPassword)) {
            return response()->json([
                'error' => 'Current password is incorrect'
            ], 404);
        }
        $user->password = Hash::make($passNew);
        $this->userRepository->update($user);
    }

    public function getLibrarians()
    {
        $librarians = [];
        $result = $this->userRepository->getLibrarians();
        foreach ($result as $item) {
            $librarian = new stdClass;
            $librarian->id = $item->id;
            $librarian->name = $item->name;
            $librarian->username = $item->username;
            $librarian->phone = $item->phone;
            $librarian->library = $item->library;
            array_push($librarians, $librarian);
        }

        return $librarians;

    }

    public function create($request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->role = RoleConstants::LIBRARIAN;
        $user->library_id = $request->library_id;
        $this->userRepository->create($user);
    }

    public function delete($id)
    {
        $this->userRepository->delete($id);
    }

    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    public function isAdmin($user)
    {
        $admin = $this->userRepository->getUserRoleAdmin();
        if ($user->role == $admin->role) {
            return true;
        }
        return false;
    }

    public function update($request, $user)
    {
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->library_id = $request->library_id;
        $this->userRepository->update($user);
    }
}
