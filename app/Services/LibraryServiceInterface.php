<?php


namespace App\Services;


interface LibraryServiceInterface
{
    public function create($request);
    public function getAll();
    public function delete($id);
    public function find($id);
    public function update($request, $library);
}
