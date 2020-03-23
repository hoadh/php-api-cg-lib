<?php

namespace Tests\Feature\api;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testAdminCreateCategoryBook()
    {
        $user = $this->loginIsAdmin();
        $data = [
            'name' => 'Truyện tranh'
        ];

        $response = $this->post('/api/categories', $data, $this->headers($user));
        $response->assertJson(['status' => 'success']);
        $response->assertJson(['message' => __('language.create_category_success')]);
    }

    public function testLibrarianCreateCategoryBook()
    {
        $user = $this->loginIsLibrarian();
        $data = [
            'name' => 'Truyện tranh'
        ];

        $response = $this->post('/api/categories', $data, $this->headers($user));
        $response->assertJson(['status' => 'success']);
        $response->assertJson(['message' => __('language.create_category_success')]);
    }

    public function testGetCategoriesBook()
    {
        $user = $this->loginIsLibrarian();

        $category = $this->getNewCategory();
        $category->save();

        $response = $this->get('/api/categories', $this->headers($user));
        $response->assertJson(['status' => 'success']);
    }

    public function testDeleteCategoryBook()
    {
        $user = $this->loginIsLibrarian();

        $category = $this->getNewCategory();
        $category->save();

        $response = $this->delete("/api/categories/$category->id", [], $this->headers($user));
        $response->assertJson(['status' => 'success']);
    }

    public function testDeleteCategoryBookNotExist()
    {
        $user = $this->loginIsLibrarian();

        $category = $this->getNewCategory();
        $category->save();

        $response = $this->delete("/api/categories/5", [], $this->headers($user));
        $response->assertJson(['status' => 'error']);
    }

    public function testUpdateCategoryBook()
    {
        $user = $this->loginIsLibrarian();
        $category = $this->getNewCategory();
        $category->save();

        $data = [
          'name' => 'Lịch sử'
        ];

        $response = $this->put("/api/categories/$category->id", $data, $this->headers($user));
        $response->assertJson(['status' => 'success']);
    }

    public function testUpdateCategoryBookNotExist()
    {
        $user = $this->loginIsLibrarian();
        $category = $this->getNewCategory();
        $category->save();

        $data = [
            'name' => 'Lịch sử'
        ];

        $response = $this->put("/api/categories/5", $data, $this->headers($user));
        $response->assertJson(['status' => 'error']);
    }
}
