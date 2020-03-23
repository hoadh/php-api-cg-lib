<?php

namespace App\Imports;

use App\Book;
use App\Http\Controllers\BookBorrowStatusConstans;
use App\Http\Controllers\BookStatusConstants;
use App\Services\BookServiceInterface;
use App\Services\CategoryServiceInterface;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToModel, WithBatchInserts, WithHeadingRow
{
    use Importable;

    protected $libraryId;
    protected $categoryService;
    protected $bookService;

    public function __construct(BookServiceInterface $bookService, CategoryServiceInterface $categoryService, $libraryId)
    {
        $this->libraryId = $libraryId;
        $this->categoryService = $categoryService;
        $this->bookService = $bookService;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!$row['tieu_de']) {
            return null;
        }
        $authors = ($row['tac_gia']) ? $row['tac_gia'] : "";
        $barcode = ($row['barcode']) ? $row['barcode'] : "";

        $book = new Book();
        $book->title = $row['tieu_de'];
        $book->authors = $authors;
        $book->isbn = $barcode;
        $book->ages = $row['nhom_tuoi'];
        $book->publishing_company = $row['nha_xuat_ban'];
        $book->library_id = $this->libraryId;

        // Set category
        $categoryId = $this->categoryService->findByName($row['danh_muc']);
        if (isset($categoryId)) {
            $book->category_id = $categoryId;
        } else {
            $book->category_id = null; // No Category
        }

        // Update with existed barcode
        $existedBook = null;
        if ($barcode != "") {
            $existedBook = $this->bookService->findByBarcode(1, $barcode);
        }

        // Existed Book (Update)
        if ($existedBook) {
            $book->status_id = $existedBook->status_id;
            $book->is_borrowing = $existedBook->is_borrowing;
            $this->bookService->update($book, $existedBook);
            return null; // do not insert new book
        }

        // New book (Insert)
        else {
            $book->status_id = BookStatusConstants::NEW;
            $book->is_borrowing = BookBorrowStatusConstans::NOTBORROWING;
            return $book;
        }
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }
}
