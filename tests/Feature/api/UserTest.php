<?php

namespace Tests\Feature\api;

use App\Http\Controllers\RoleConstants;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use phpDocumentor\Reflection\Types\Null_;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JWTAuth;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserLoginSuccessfully()
    {
        $user = $this->getNewUserAdmin();
        $user->save();

        $payload = ['username' => $user->username, 'password' => $this->defaultAdminPassword];

        $response = $this->post('/api/login', $payload);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function testUserLoginFail()
    {
        $user = $this->getNewUserAdmin();
        $user->save();

        $payload = ['username' => $user->username, 'password' => '12123'];

        $response = $this->post('/api/login', $payload);
        $response->assertStatus(401);
        $response->assertJson(['status' => 'error']);
    }

    public function testAdminShowListLibrarian()
    {
        $user = $this->loginIsAdmin();

        $librarian = $this->getNewUserLibrarian();
        $librarian->save();

        $response = $this->get('/api/librarians', $this->headers($user));
        $response->assertJson(['status' => 'success']);
    }

    public function testUserCanNotShowListLibrarian()
    {
        $user = $this->loginIsLibrarian();

        $librarian = $this->getNewUserLibrarian();
        $librarian->save();

        $response = $this->get('/api/librarians', $this->headers($user));
        $response->assertStatus(403);
    }

    public function testAdminCreateUserRoleLibrarian()
    {
        $user = $this->loginIsAdmin();

        $data = [
            'name' => 'Phan',
            'username' => 'demo',
            'phone' => '0987263740',
            'password' => '12345678',
            'role' => RoleConstants::LIBRARIAN,
            'library_id' => $this->defaultLibraryId,
        ];

        $response = $this->post('/api/librarians/create', $data, $this->headers($user));
        $response->assertJson(['status' => 'success']);
    }

    public function testAdminCanNotDeleteUserAdmin()
    {
        $user = $this->loginIsAdmin();

        $response = $this->delete("/api/librarians/$user->id/delete", [], $this->headers($user));
        $response->assertJson(['status' => 'error']);
        $response->assertJson(['message' => __('language.can_not_delete_user')]);
    }

    public function testAdminDeleteUser()
    {
        $user = $this->loginIsAdmin();

        $librarian = $this->getNewUserLibrarian();
        $librarian->save();

        $response = $this->delete("/api/librarians/$librarian->id/delete", [], $this->headers($user));
        $response->assertJson(['status' => 'success']);
        $response->assertJson(['message' => __('language.delete_user_success')]);

    }

    public function testAdminDeleteUserNotFound()
    {
        $user = $this->loginIsAdmin();

        $librarian = $this->getNewUserLibrarian();
        $librarian->save();

        $response = $this->delete("/api/librarians/10/delete", [], $this->headers($user));
        $response->assertJson(['status' => 'error']);
        $response->assertJson(['message' => __('language.can_not_find_user')]);
    }

    public function testAdminUpdateUser()
    {
        $user = $this->loginIsAdmin();
        $librarian = $this->getNewUserLibrarian();
        $librarian->save();

        $data = [
            'name' => 'Phan',
            'phone' => '0987343740',
            'library_id' => $this->defaultLibraryId,
        ];

        $response = $this->post("/api/librarians/$librarian->id/update", $data, $this->headers($user));
        $response->assertJson(['status' => 'success']);
    }

    public function testAdminShowInfoUser()
    {
        $user = $this->loginIsAdmin();

        $librarian = $this->getNewUserLibrarian();
        $librarian->save();

        $response = $this->get("/api/librarians/$librarian->id/", $this->headers($user));
        $response->assertJson(['status' => 'success']);
    }

    public function testAdminShowInfoUserNotExist()
    {
        $user = $this->loginIsAdmin();

        $librarian = $this->getNewUserLibrarian();
        $librarian->save();

        $response = $this->get("/api/librarians/5/", $this->headers($user));
        $response->assertJson(['status' => 'error']);
        $response->assertJson(['message' => __('language.can_not_find_user')]);
    }

    public function testLibrarianCanNotShowInfoUser()
    {
        $user = $this->loginIsLibrarian();
        $response = $this->get("/api/librarians/$user->id/", $this->headers($user));
        $response->assertJson(['status' => 'error']);
        $response->assertStatus(403);
    }
}

