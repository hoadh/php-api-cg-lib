<?php


namespace App\Imports;


use App\Services\BookServiceInterface;
use App\Services\CategoryServiceInterface;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BookSheetsImport implements WithMultipleSheets
{

    protected $libraryId;
    protected $categoryService;
    protected $bookService;

    public function __construct(BookServiceInterface $bookService, CategoryServiceInterface $categoryService, $libraryId)
    {
        $this->libraryId = $libraryId;
        $this->categoryService = $categoryService;
        $this->bookService = $bookService;
    }

    public function sheets(): array
    {
        return [
            'Sach' => new BooksImport($this->bookService, $this->categoryService, $this->libraryId)
        ];
    }
}
