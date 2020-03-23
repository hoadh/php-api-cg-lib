<?php


namespace App\Repositories\Eloquent;


use App\Borrow;
use App\Http\Controllers\BorrowStatusConstants;
use App\Repositories\Contracts\BorrowRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BorrowEloquentRepository extends EloquentRepository implements  BorrowRepositoryInterface
{

    /**
     * get Model
     * @return string
     */
    public function getModel()
    {
        return Borrow::class;
    }

    public function getBorrowsByLibraryId($id)
    {
        return Borrow::where('library_id', $id)->where('status', BorrowStatusConstants::BORROWING)->get();
    }

    public function findByLibraryId($lib_id, $borrow_id)
    {
        return Borrow::where('library_id', $lib_id)
                        ->find($borrow_id);
    }

    public function filterBorrow($filter) {
        $where = [];
        if ($filter["library_id"] > 0) {
            $where[] = ['borrows.library_id', '=', $filter["library_id"]];
        }
        $where[] = ['borrows.created_at', '>=', $filter["start_date"]];
        $where[] = ['borrows.created_at', '<=', $filter["end_date"]];

        $borrows = Borrow::where($where)
            ->leftJoin('books', function ($join) use ($filter) {
                $join->on('books.id', '=', 'borrows.book_id');
                if ($filter["category_id"] > 0) {
                    $join->where('books.category_id', '=', $filter["category_id"]);
                }
            })
            ->leftJoin('libraries', 'libraries.id', '=', 'borrows.library_id')
            ->rightJoin('categories', 'categories.id', '=', 'books.category_id')
            ->select('borrows.library_id as library_id', 'libraries.name as library_name', 'categories.name as category_name')
            ->addSelect(DB::raw('COUNT(borrows.id) as borrowed_count'))
            ->addSelect(DB::raw('SUM(CASE WHEN borrows.status = 2 THEN 1 ELSE 0 END) as returned_count'))
            ->groupBy(['library_id', 'library_name', 'category_name'])
            ->get();

        return $borrows;
    }
}
