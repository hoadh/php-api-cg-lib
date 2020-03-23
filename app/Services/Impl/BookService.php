<?php


namespace App\Services\Impl;


use App\Book;
use App\Http\Controllers\BookBorrowStatusConstans;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Services\BaseService;
use App\Services\BookServiceInterface;
use stdClass;

class BookService extends BaseService implements BookServiceInterface
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function getBooksByLibraryId($id)
    {
        $arrBooks = [];
        $books = $this->bookRepository->getBooksByLibraryId($id);
        foreach ($books as $item) {
            $book = new stdClass();
            $book->id = $item->id;
            $book->title = $item->title;
            $book->authors = $item->authors;
            $book->isbn = $item->isbn;
            $book->status_id = $item->status_id;
            $book->category = $item->category;
            array_push($arrBooks, $book);
        }

        return $arrBooks;
    }

    public function create($request)
    {
        $book = new Book();
        $book->title = $request->title;
        $book->authors = $request->authors;
        $book->isbn = $request->isbn;
        $book->status_id = $request->status_id;
        $book->is_borrowing = BookBorrowStatusConstans::NOTBORROWING;
        $book->category_id = $request->category_id;
        $book->library_id = $request->library_id;
        $book->ages = $request->ages;
        $book->publishing_company = $request->publishing_company;
        $this->bookRepository->create($book);

    }

    public function findByLibraryId($libraryId, $bookId)
    {
        return $this->bookRepository->findByLibraryId($libraryId, $bookId);
    }

    public function findByBarcode($libraryId, $barcode)
    {
        return $this->bookRepository->findByBarcode($libraryId, $barcode);
    }

    public function delete($id)
    {
        $this->bookRepository->delete($id);
    }

    public function update($request, $book)
    {
        $book->title = $request->title;
        $book->authors = $request->authors;
        $book->isbn = $request->isbn;
        $book->status_id = $request->status_id;
        $book->category_id = $request->category_id;
        $book->ages = $request->ages;
        $book->publishing_company = $request->publishing_company;
        $this->bookRepository->update($book);
    }

    public function updateStatus($status, $book)
    {
        $book->status_id = $status;
        $this->bookRepository->update($book);
    }

    public function getAll()
    {
        $arrBooks = [];
        $books = $this->bookRepository->getAll();
        foreach ($books as $item) {
            $book = $this->setNewBook($item);
            array_push($arrBooks, $book);
        }
        return $arrBooks;
    }

    public function getBooksByStatusBorrow($library_id ,$statusBorrow)
    {
        $books = $this->bookRepository->getBooksByStatusBorrow($library_id, $statusBorrow);
        $arrBooks = [];
        foreach ($books as $item) {
            $book = $this->setNewBook($item);
            array_push($arrBooks, $book);
        }
        return $arrBooks;

    }

    public function getBooksByClauses($arr)
    {
        $data = [];
        foreach ($arr as $key => $value) {
            $data[] = [
                'field' => $key,
                'operator' => '=',
                'value' => $value,
            ];
        }

        $arrBooks = [];
        $books =  $this->bookRepository->findByClauses($data, 'title', 'ASC');
        foreach ($books as $item) {
            $book = $this->setNewBook($item);
            array_push($arrBooks, $book);
        }
        return $arrBooks;
    }

    public function filterBooksByClauses($equalClauses, $likeClauses)
    {
        $data = [];
        foreach ($equalClauses as $key => $value) {
            $data[] = [
                'field' => $key,
                'operator' => '=',
                'value' => $value,
            ];
        }

        foreach ($likeClauses as $key => $value) {
            $val = '%' . $value . '%';
            $data[] = [
                'field' => $key,
                'operator' => 'LIKE',
                'value' => $val
            ];
        }
        $arrBooks = [];
        $books =  $this->bookRepository->findByClauses($data, 'title', 'ASC');
        foreach ($books as $item) {
            $book = $this->setNewBook($item);
            array_push($arrBooks, $book);
        }
        return $arrBooks;
    }

    /**
     * @param $item
     * @return stdClass
     */
    public function setNewBook($item)
    {
        $book = new stdClass();
        $book->id = $item->id;
        $book->title = $item->title;
        $book->authors = $item->authors;
        $book->isbn = $item->isbn;
        $book->is_borrowing = $item->is_borrowing;
        $book->status_id = $item->status_id;
        $book->category = $item->category;
        $book->library = $item->library;
        $book->ages = $item->ages;
        $book->publishing_company = $item->publishing_company;
        return $book;
    }
}
