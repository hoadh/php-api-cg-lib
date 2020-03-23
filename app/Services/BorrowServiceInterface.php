<?php


namespace App\Services;


interface BorrowServiceInterface
{
    public function create($request, $lib_id);
    public function getAll($lib_id);
    public function findByLibraryId($lib_id, $borrow_id);
    public function update($borrow, $request);
}
