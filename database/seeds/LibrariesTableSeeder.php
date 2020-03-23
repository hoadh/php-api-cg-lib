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
        $library->name = "Thu vien uoc mo My Dinh";
        $library->image = "storage/images/libraries/default.jpg";
        $library->desc = "Thư viện ước mơ Mỹ Đình";
        $library->address = "Ha Noi";
        $library->phone = "098765343";
        $library->manager = "Admin";
        $library->manager_address = "Ha Noi";
        $library->manager_phone = "098765342";
        $library->save();
    }
}
