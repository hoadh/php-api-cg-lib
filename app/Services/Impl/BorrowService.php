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
        foreach ($request->book as $item) {
            $borrow = new Borrow();

            $borrow->customer_id = $request->customer_id;
            $borrow->book_id = $item['id'];

            $book = $this->bookRepository->findByLibraryId($lib_id, $item['id']);

            $book->status_id = $item['status'];
            $book->is_borrowing = BookBorrowStatusConstans::BORROWING;
            $this->bookRepository->update($book);

            $borrow->library_id = $lib_id;
            $borrow->pay_day = $request->pay_day;
            $borrow->status = BorrowStatusConstants::BORROWING;
            $this->borrowRepository->create($borrow);
        }
    }

    public function getAll($lib_id)
    {
        $borrows = $this->borrowRepository->getBorrowsByLibraryId($lib_id);
        $arr = [];
        foreach ($borrows as $item) {
            $borrow = $this->setNewBorrow($item);
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
    public function setNewBorrow($data)
    {
        if ($data) {
            $borrow = new \stdClass();
            $borrow->id = $data->id;
            $borrow->customer = $data->customer;
            $borrow->book = $data->book;
            $borrow->pay_day = $data->pay_day;
            $borrow->status = $data->status;
            $borrow->borrow_day = $data->created_at->format('Y-m-d');
            $borrow->return_day_reality = $data->return_day_reality;
            return $borrow;
        }
    }

    public function update($borrow, $request)
    {
        $borrow->return_day_reality = date('Y-m-d');
        $borrow->status = BorrowStatusConstants::BORROWED;
        $this->borrowRepository->update($borrow);
        $book = $borrow->book;
        $book->status_id = $request->status_book;
        $book->is_borrowing = BookBorrowStatusConstans::NOTBORROWING;
        $this->bookRepository->update($book);
    }
}
