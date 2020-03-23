<?php

namespace App\Http\Controllers\Api;

use App\Exports\SampleExcelExport;
use App\Imports\BookSheetsImport;
use App\Services\BookServiceInterface;
use App\Services\CategoryServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Exceptions\SheetNotFoundException;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    protected $bookService;
    protected $categoryService;

    public function __construct(CategoryServiceInterface $categoryService, BookServiceInterface $bookService)
    {
        $this->categoryService = $categoryService;
        $this->bookService = $bookService;
    }

    public function getBooksByLibraryId($id)
    {
        try {
            $books = $this->bookService->getBooksByLibraryId($id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $books
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $this->bookService->create($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.create_book_success')
        ], 200);
    }

    public function destroy($libraryId, $bookId)
    {
        try {
            $book = $this->bookService->findByLibraryId($libraryId, $bookId);
            if (!$book) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_book')
                ], 500);
            }
            $this->bookService->delete($book->id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.delete_book_success')
        ], 200);
    }

    public function update(Request $request, $libraryId, $bookId)
    {
        try {
            $book = $this->bookService->findByLibraryId($libraryId, $bookId);
            if (!$book) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_book')
                ], 500);
            }
            $this->bookService->update($request, $book);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.update_book_success')
        ], 200);
    }

    public function show($libraryId, $bookId)
    {
        try {
            $book = $this->bookService->findByLibraryId($libraryId, $bookId);
            if (!$book) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_book')
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $book
        ], 200);
    }

    public function index()
    {
        if (!$this->userCan('system-management')) {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized'], 403);
        }

        try {
            $books = $this->bookService->getAll();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $books
        ], 200);
    }

    public function getBookByStatusBorrow($libary_id, $statusBorrow)
    {
        try {
            $books = $this->bookService->getBooksByStatusBorrow($libary_id, $statusBorrow);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $books
        ], 200);
    }

    public function getBooksByFields(Request $request)
    {
        if (!$this->userCan('system-management')) {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized'], 403);
        }

        try {
            $books = $this->bookService->getBooksByClauses($request->all());
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $books
        ], 200);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function importBooksFromFile(Request $request)
    {
        try {
            $booksSheetImport = new BookSheetsImport($this->bookService, $this->categoryService, $request->library_id);
            Excel::import($booksSheetImport, $request->file("file")); // TODO remove Excel facade (use Importable instead) for avoid fresh deloyment on other serve

        } catch (SheetNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi định dạng file Excel'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã nhập sách từ file thành công'
        ], 200);
    }

    /**
     * Export sample excel file
     */
    public function exportExcelSample(Request $request) {
        return Excel::download(new SampleExcelExport(), 'sample.xlsx');
    }

    /**
     * Get fields and their data from request
     * @param $request
     * @param $fields
     * @return array
     */
    private function getFieldsFromRequest($request, $fields) {
        $clauses = [];
        foreach ($fields as $field) {
            if (array_key_exists($field, $request) && $request[$field] != "") {
                $clauses[$field] = $request[$field];
            }
        }
        return $clauses;
    }

    /**
     * Filter books by fields (from params request)
     * @param Request $request
     * @param $id - Library's id
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterBooks(Request $request, $id) {
        $reqs = $request->all();

        $equalClauses = $this->getFieldsFromRequest($reqs, ["category_id", "status_id"]);
        $equalClauses["library_id"] = $id;
        $likeClauses = $this->getFieldsFromRequest($reqs, ["title", "authors", "isbn", "publishing_company", "ages"]);

        try {
            $books = $this->bookService->filterBooksByClauses($equalClauses, $likeClauses);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $books
        ], 200);
    }
}
