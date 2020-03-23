<?php


namespace App\Services;


interface UserServiceInterface
{
    public function getAll();
    public function changePassword($user, $request);
    public function getLibrarians();
    public function create($request);
    public function delete($id);
    public function find($id);
    public function isAdmin($user);
    public function update($request, $user);
}
