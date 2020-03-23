<?php


namespace App\Repositories\Eloquent;


use App\Http\Controllers\RoleConstants;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\User;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{

    /**
     * get Model
     * @return string
     */
    public function getModel()
    {
        return User::class;
    }

    public function getLibrarians()
    {
       $librarians =  User::where('role', RoleConstants::LIBRARIAN)->get();
       return $librarians;
    }

    public function getUserRoleAdmin()
    {
        $admin = User::find(1);
        return $admin;
    }
}
