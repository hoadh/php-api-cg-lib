<?php


namespace App\Services;


interface BookServiceInterface
{
    public function getBooksByLibraryId($id);

    public function create($request);

    public function findByLibraryId($libraryId, $bookId);

    public function findByBarcode($libraryId, $barcode);

    public function delete($id);

    public function update($request, $book);

    public function updateStatus($status, $book);

    public function getAll();

    public function getBooksByStatusBorrow($library_id, $statusBorrow);

    public function getBooksByClauses($arr);
}
