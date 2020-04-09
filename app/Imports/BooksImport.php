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

        $book = new Book();
        $book->title = $row['tieu_de'];
        $book->authors = $authors;
        $book->note = $row['ghi_chu'];
        $book->library_id = $this->libraryId;

        // Set category
        $categoryId = $this->categoryService->findByName($row['danh_muc']);
        if (isset($categoryId)) {
            $book->category_id = $categoryId;
        } else {
            $book->category_id = null; // No Category
        }

        $book->status_id = BookStatusConstants::NEW;
        return $book;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }
}
