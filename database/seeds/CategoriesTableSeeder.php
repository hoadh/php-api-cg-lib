<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new \App\Category();
        $category->id = 1;
        $category->name = "Quản trị, doanh nghiệp";
        $category->save();

        $category = new \App\Category();
        $category->id = 2;
        $category->name = "Tạp chí chuyên đề, tạp chí lập trình...";
        $category->save();

        $category = new \App\Category();
        $category->id = 3;
        $category->name = "Lập trình";
        $category->save();

        $category = new \App\Category();
        $category->id = 4;
        $category->name = "Phát triển cá nhân, kỹ năng, tư duy...";
        $category->save();

        $category = new \App\Category();
        $category->id = 5;
        $category->name = "Giáo dục, đào tạo giảng viên...";
        $category->save();

        $category = new \App\Category();
        $category->id = 6;
        $category->name = "Văn học, tiểu thuyết, hồi ký...";
        $category->save();

        $category = new \App\Category();
        $category->id = 7;
        $category->name = "Khoa học xã hội, văn hóa nghệ thuật, tôn giáo, tâm linh, nghệ thuật...";
        $category->save();

        $category = new \App\Category();
        $category->id = 8;
        $category->name = "Bán hàng, Tư vấn tuyển sinh";
        $category->save();

        $category = new \App\Category();
        $category->id = 9;
        $category->name = "Marketing";
        $category->save();
    }
}
