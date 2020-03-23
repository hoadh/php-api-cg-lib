<?php


namespace App\Repositories\Contracts;


interface BorrowRepositoryInterface
{
    public function getBorrowsByLibraryId($id);
    public function findByLibraryId($lib_id, $borrow_id);
}
