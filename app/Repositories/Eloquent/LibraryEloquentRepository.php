<?php


namespace App\Repositories\Eloquent;


use App\Library;
use App\Repositories\Contracts\LibraryRepositoryInterface;

class LibraryEloquentRepository extends EloquentRepository implements LibraryRepositoryInterface
{

    /**
     * get Model
     * @return string
     */
    public function getModel()
    {
        return Library::class;
    }
}
