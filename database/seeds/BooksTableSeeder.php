<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $book = new \App\Book();
        $book->id = 1;
        $book->title = "Tri Thức Về Vạn Vật - Một Thế Giới Trực Quan Chưa Từng Thấy";
        $book->authors = "DK";
//        $book->isbn = "8935251408089";
        $book->status_id = 1;
        $book->category_id = 1;
        $book->library_id = 1;
        $book->save();
    }
}
