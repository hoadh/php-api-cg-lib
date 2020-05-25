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
        $user->role = RoleConstants::ADMIN;
        $user->password = Hash::make("admin");
        $user->save();

        $user = new User();
        $user->id = 2;
        $user->name = "Bui Thi Quyen";
        $user->username = "quyen";
        $user->role = RoleConstants::LIBRARIAN;
        $user->password = Hash::make("12345678");
        $user->library_id = 1;
        $user->save();

        $user = new User();
        $user->id = 3;
        $user->name = "Le Thi Hang";
        $user->username = "hang";
        $user->role = RoleConstants::LIBRARIAN;
        $user->library_id = 1;
        $user->password = Hash::make("12345678");
        $user->save();

        $user = new User();
        $user->id = 4;
        $user->name = "Trang Le";
        $user->username = "trangle";
        $user->role = RoleConstants::LIBRARIAN;
        $user->library_id = 1;
        $user->password = Hash::make("12345678");
        $user->save();
    }
}
