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
        $book->title = "Lap trih PHP";
        $book->authors = "FPT";
        $book->isbn = "123sdffgfgdf";
        $book->status_id = 1;
        $book->category_id = 1;
        $book->library_id = 1;
        $book->save();
    }
}
