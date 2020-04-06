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
        $book->status_id = 1;
        $book->category_id = 1;
        $book->library_id = 1;
        $book->save();

        $book2 = new \App\Book();
        $book2->id = 2;
        $book2->title = "Chiến lược đại dương xanh";
        $book2->authors = "W. Chan Kim & Renee Mauborgne";
        $book2->status_id = 1;
        $book2->category_id = 1;
        $book2->library_id = 1;
        $book2->note = "Sách Agilead tặng nhân dịp sinh nhật CodeGym.";
        $book2->save();
    }
}
