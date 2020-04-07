<?php


namespace App\Services\Impl;


use App\Borrow;
use App\Http\Controllers\BookBorrowStatusConstans;
use App\Http\Controllers\BorrowStatusConstants;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\BorrowRepositoryInterface;
use App\Services\BaseService;
use App\Services\BorrowServiceInterface;

class BorrowService extends BaseService implements BorrowServiceInterface
{
    protected $borrowRepository;
    protected $bookRepository;

    public function __construct(BorrowRepositoryInterface $borrowRepository,
                                BookRepositoryInterface $bookRepository)
    {
        $this->borrowRepository = $borrowRepository;
        $this->bookRepository = $bookRepository;
    }

    public function create($request, $lib_id)
    {
        foreach ($request->books as $item) {
            $borrow = new Borrow();
            $borrow->library_id = $lib_id;
//            $borrow->customer_id = $request->customer_id;
            $borrow->full_name = $request->full_name;
            $borrow->department = $request->department;
            $borrow->book_id = $item['id'];
            $borrow->date_borrowed = date('Y-m-d');
            $borrow->date_expected_returned = $request->date_expected_returned;
            $borrow->status_id = BorrowStatusConstants::BORROWING;
            $this->borrowRepository->create($borrow);

            $book = $this->bookRepository->findByLibraryId($lib_id, $item['id']);
            $book->status_id = BookBorrowStatusConstans::BORROWED;
            $this->bookRepository->update($book);
        }
    }

    public function getAll($lib_id)
    {
        $borrows = $this->borrowRepository->getBorrowsByLibraryId($lib_id);
        $arr = [];
        foreach ($borrows as $item) {
            $borrow = $this->getBorrowResponse($item);
            array_push($arr, $borrow);
        }

        return $arr;
    }

    public function getCountBorrows($request) {
        $filter = [];
        $req = $request->all();
        $borrows = $this->filterBorrows($req)->toArray();
        return $borrows;

//        $result = [];
//        foreach ($borrows as $key => $value) {
//        }
    }

    private function filterBorrows($req) {
        $filter["library_id"]   = $req["library_id"];
        $filter["category_id"]  = $req["category_id"];
        $filter["start_date"]   = $req["start_date"] . ' 00:00:00';
        $filter["end_date"]     = $req["end_date"] . ' 23:59:59';

        $borrow = $this->borrowRepository->filterBorrow($filter);
        return $borrow;
    }

    public function findByLibraryId($lib_id, $borrow_id)
    {
        $borrow = $this->borrowRepository->findByLibraryId($lib_id, $borrow_id);
        return $borrow;
    }

    /**
     * @param $data
     * @return \stdClass
     */
    public function getBorrowResponse($data)
    {
        if ($data) {
            $borrow = new \stdClass();
            $borrow->id = $data->id;
//            $borrow->customer = $data->customer;
            $borrow->full_name = $data->full_name;
            $borrow->department = $data->department;
            $borrow->book = $data->book;
            $borrow->date_expected_returned = $data->date_expected_returned;
            $borrow->date_borrowed = $data->created_at->format('Y-m-d');
            $borrow->date_actual_returned = $data->date_actual_returned;
            return $borrow;
        }
    }

    public function update($borrow, $request)
    {
        $borrow->date_actual_returned = date('Y-m-d');
        $borrow->status_id = BorrowStatusConstants::RETURNED;
        $this->borrowRepository->update($borrow);

        $book = $borrow->book;
        $book->status_id = BookBorrowStatusConstans::AVAILABLE;
        $this->bookRepository->update($book);
    }
}
