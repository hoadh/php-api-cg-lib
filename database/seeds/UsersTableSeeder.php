<?php

use App\Http\Controllers\RoleConstants;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->id = 1;
        $user->name = "admin";
        $user->username = "admin";
        $user->phone = "0856987382";
        $user->role = RoleConstants::ADMIN;
        $user->password = Hash::make("admin");
        $user->save();

        $user = new User();
        $user->id = 2;
        $user->name = "Quyen";
        $user->username = "quyen";
        $user->phone = "0909315962";
        $user->role = RoleConstants::LIBRARIAN;
        $user->password = Hash::make("12345678");
        $user->library_id = 1;
        $user->save();

        $user = new User();
        $user->id = 3;
        $user->name = "Hang";
        $user->username = "hang";
        $user->phone = "0989526632";
        $user->role = RoleConstants::LIBRARIAN;
        $user->library_id = 1;
        $user->password = Hash::make("12345678");
        $user->save();
    }
}
