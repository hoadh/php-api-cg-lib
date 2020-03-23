<?php


namespace App\Repositories\Contracts;


interface RepositoryInterface
{
    public function getAll();

    public function create($object);

    public function delete($id);

    public function update($object);

    public function find($id, $columns = array('*'));

    public function findByClauses(array $data);
}
