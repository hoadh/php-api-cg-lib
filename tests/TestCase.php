<?php

namespace Tests;

use App\Category;
use App\Library;
use App\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DefaultConstants;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    protected function headers($user = null)
    {
        $headers = ['Accept' => 'application/json'];

        if (!is_null($user)) {
            $token = JWTAuth::fromUser($user);
            JWTAuth::setToken($token);
            $headers['Authorization'] = 'Bearer '.$token;
        }

        return $headers;
    }

    public function loginIsAdmin()
    {
        $user = new User();
        $user->name = $this->defaultAdminName;
        $user->username = $this->defaultAdminUserName;
        $user->phone = $this->defaultAdminPhone;
        $user->password = Hash::make($this->defaultAdminPassword);
        $user->role = $this->defaultAdminRole;
        $user->library_id = null;
        $user->save();
        return $user;
    }

    public function loginIsLibrarian()
    {
        $user = new User();
        $user->name = $this->defaultLibrarianName;
        $user->username = $this->defaultLibrarianUserName;
        $user->phone = $this->defaultLibrarianPhone;
        $user->password = Hash::make($this->defaultLibrarianPassword);
        $user->role = $this->defaultLibrarianRole;
        $user->library_id = $this->defaultLibraryId;
        $user->save();
        return $user;
    }

    public function getNewUserAdmin()
    {
        $user = new User();
        $user->name = $this->defaultAdminName;
        $user->username = $this->defaultAdminUserName;
        $user->phone = $this->defaultAdminPhone;
        $user->password = Hash::make($this->defaultAdminPassword);
        $user->role = $this->defaultAdminRole;
        $user->library_id = null;
        return $user;
    }

    public function getNewUserLibrarian()
    {
        $user = new User();
        $user->name = $this->secondLibrarianName;
        $user->username = $this->secondLibrarianUsername;
        $user->phone = $this->secondLibrarianPhone;
        $user->password = Hash::make($this->secondLibrarianPassword);
        $user->role = $this->defaultLibrarianRole;
        $user->library_id = $this->defaultLibraryId;
        return $user;
    }

    public function getNewLibrary()
    {
        $library = new Library();
        $library->name = $this->defaultLibraryName;
        $library->image = $this->defaultLibraryImage;
        $library->address = $this->defaultLibraryAddress;
        $library->desc = $this->defaultLibraryDesc;
        $library->phone = $this->defaultLibraryPhone;
        $library->manager = $this->defaultLibraryManager;
        $library->manager_address = $this->defaultLibraryManagerAddress;
        $library->manager_phone = $this->defaultLibraryManagerPhone;
        return $library;
    }

    public function getNewCategory()
    {
        $category = new Category();
        $category->name = $this->defaultCategoryName;
        return $category;
    }
}
