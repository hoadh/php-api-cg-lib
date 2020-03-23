<?php


namespace App\Repositories\Eloquent;


use App\Book;
use App\Repositories\Contracts\BookRepositoryInterface;

class BookEloquentRepository extends EloquentRepository implements BookRepositoryInterface
{

    /**
     * get Model
     * @return string
     */
    public function getModel()
    {
        return Book::class;
    }

    public function getBooksByLibraryId($id)
    {
        $books = Book::where('library_id', $id)->orderBy("title")->get();
        return $books;
    }

    public function findByLibraryId($libraryId, $bookId)
    {
        $book = Book::where('library_id', $libraryId)
            ->where('id', $bookId)->first();
        return $book;
    }

    public function findByBarcode($libraryId, $barcode)
    {
        $book = Book::where('library_id', $libraryId)
            ->where('isbn', $barcode)->first();
        return $book;
    }

    public function getBooksByStatusBorrow($libraryId, $statusBorrow)
    {
        return Book::where('library_id', $libraryId)
            ->where('is_borrowing', $statusBorrow)->orderBy("title")->get();
    }
}
