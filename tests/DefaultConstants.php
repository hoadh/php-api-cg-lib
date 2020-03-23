<?php


namespace Tests;


use App\Http\Controllers\RoleConstants;

trait DefaultConstants
{
    //User
    public $defaultAdminId = 1;
    public $defaultAdminUserName = "admin";
    public $defaultAdminName = "Admin";
    public $defaultAdminPhone = "098676352";
    public $defaultAdminPassword = "admin";
    public $defaultAdminRole = RoleConstants::ADMIN;

    public $defaultLibrarianId = 2;
    public $defaultLibrarianUserName = "librarian";
    public $defaultLibrarianName = "Librarian";
    public $defaultLibrarianPhone = "0982763520";
    public $defaultLibrarianPassword = "librarian";
    public $defaultLibrarianRole = RoleConstants::LIBRARIAN;

    public $secondLibrarianId = 3;
    public $secondLibrarianUsername = "librarian3";
    public $secondLibrarianPhone = "0982763420";
    public $secondLibrarianName = "Librarian3";
    public $secondLibrarianPassword = "librarian3";

    //Library
    public $defaultLibraryId = 1;
    public $defaultLibraryName = "Thu vien HN";
    public $defaultLibraryAddress = "My Dinh";
    public $defaultLibraryPhone = "0987754321";
    public $defaultLibraryDesc = "Thu vien My Dinh";
    public $defaultLibraryImage = "storage/images/libraries/default.jpg";
    public $defaultLibraryManager = "Admin";
    public $defaultLibraryManagerAddress = "Admin";
    public $defaultLibraryManagerPhone = "0987654321";

    //category
    public $defaultCategoryId = 1;
    public $defaultCategoryName = "Văn học";

}
