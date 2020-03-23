<?php


namespace App\Services;


interface CategoryServiceInterface
{
    public function getAll();
    public function create($request);
    public function find($id);
    public function findByName($name);
    public function delete($id);
    public function update($request, $category);
}
