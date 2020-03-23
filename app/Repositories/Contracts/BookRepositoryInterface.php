<?php


namespace App\Repositories\Contracts;


interface BookRepositoryInterface
{
    public function getBooksByLibraryId($id);
    public function findByLibraryId($libraryId, $bookId);
    public function findByBarcode($libraryId, $barcode);
    public function getBooksByStatusBorrow($libary_id ,$statusBorrow);
}
