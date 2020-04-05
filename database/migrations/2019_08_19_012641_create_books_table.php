<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('authors');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('library_id');
            $table->integer('status_id')->default(1);
            $table->string('note')->default('');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('library_id')->references('id')->on('libraries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
