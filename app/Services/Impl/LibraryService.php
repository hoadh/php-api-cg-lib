<?php


namespace App\Services\Impl;


use App\Library;
use App\Repositories\Contracts\LibraryRepositoryInterface;
use App\Services\BaseService;
use App\Services\LibraryServiceInterface;

class LibraryService extends BaseService implements LibraryServiceInterface
{
    protected $libraryRepository;
    public function __construct(LibraryRepositoryInterface $libraryRepository)
    {
        $this->libraryRepository = $libraryRepository;
    }

    public function create($request)
    {
        $library = new Library();
        $library->name = $request->name;
        $library->address = $request->address;
        $library->phone = $request->phone;
        $library->desc = $request->desc;
        $library->manager = $request->manager;
        $library->manager_address = $request->manager_address;
        $library->manager_phone = $request->manager_phone;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images/libraries', 'public');
            $library->image = 'storage/' . $path;
        } else {
            $library->image = 'storage/images/libraries/default.png';
        }

        $this->libraryRepository->create($library);
    }

    public function getAll()
    {
        return $this->libraryRepository->getAll();
    }

    public function delete($id)
    {
        $this->libraryRepository->delete($id);
    }

    public function find($id)
    {
        return $this->libraryRepository->find($id);
    }

    public function update($request, $library)
    {
        $library->name = $request->name;
        $library->address = $request->address;
        $library->phone = $request->phone;
        $library->desc = $request->desc;
        $library->manager = $request->manager;
        $library->manager_address = $request->manager_address;
        $library->manager_phone = $request->manager_phone;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images/libraries', 'public');
            $library->image = 'storage/' . $path;
        }

        $this->libraryRepository->update($library);
    }
}
