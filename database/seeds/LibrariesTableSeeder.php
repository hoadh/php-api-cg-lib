<?php

use App\Library;
use Illuminate\Database\Seeder;

class LibrariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $library = new Library();
        $library->id = 1;
        $library->name = "Thư viện CodeGym Moncity";
        $library->image = "storage/images/libraries/default.jpg";
        $library->desc = "Tủ sách CodeGym Moncity";
        $library->address = "Hà Nội";
        $library->phone = "02462538829";
        $library->save();
    }
}
