<?php

namespace Tests\Feature\api;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LibraryTest extends TestCase
{
    use DatabaseMigrations;

    public function testAdminCreateLibrary()
    {
        $user = $this->loginIsAdmin();

        $data = [
            "name" => $this->defaultLibraryName,
            "address" => $this->defaultLibraryAddress,
            "phone" => $this->defaultLibraryPhone,
            "desc" => $this->defaultLibraryDesc,
            "image" => "",
            "manager" => $this->defaultLibraryManager,
            "manager_phone" => $this->defaultLibraryManagerPhone,
            "manager_address" => $this->defaultLibraryManagerAddress
        ];

        $response = $this->post('/api/libraries/create', $data, $this->headers($user));
        $response->assertJson(['status' => 'success']);
    }

    public function testUserCanNotCreateLibrary()
    {
        $library = $this->getNewLibrary();
        $library->save();

        $user = $this->loginIsLibrarian();

        $data = [
            "name" => $this->defaultLibraryName,
            "address" => $this->defaultLibraryAddress,
            "phone" => $this->defaultLibraryPhone,
            "desc" => $this->defaultLibraryDesc,
            "manager" => $this->defaultLibraryManager,
            "manager_phone" => $this->defaultLibraryManagerPhone,
            "manager_address" => $this->defaultLibraryManagerAddress
        ];

        $response = $this->post('/api/libraries/create', $data, $this->headers($user));
        $response->assertStatus(403);
    }

    public function testAdminViewListLibraries()
    {
        $user = $this->loginIsAdmin();

        $library = $this->getNewLibrary();
        $library->save();

        $response = $this->get('/api/libraries', $this->headers($user));
        $response->assertJson(['status' => 'success']);
    }

    public function testUserCanNotViewListLibraries()
    {
        $user = $this->loginIsLibrarian();

        $library = $this->getNewLibrary();
        $library->save();

        $response = $this->get('/api/libraries', $this->headers($user));
        $response->assertStatus(403);
    }

    public function testAdminShowInfoLibrary()
    {
        $user = $this->loginIsAdmin();

        $library = $this->getNewLibrary();
        $library->save();

        $response = $this->get("/api/libraries/$library->id", $this->headers($user));
        $response->assertJson(['status' => 'success']);
    }

    public function testAdminShowInfoLibraryNotExist()
    {
        $user = $this->loginIsAdmin();

        $library = $this->getNewLibrary();
        $library->save();

        $response = $this->get("/api/libraries/5", $this->headers($user));
        $response->assertJson(['status' => 'error']);
    }

    public function testLibrarianCanNotShowInfoLibrary()
    {
        $user = $this->loginIsLibrarian();

        $library = $this->getNewLibrary();
        $library->save();

        $response = $this->get("/api/libraries/$library->id", $this->headers($user));
        $response->assertJson(['status' => 'error']);
    }
}
