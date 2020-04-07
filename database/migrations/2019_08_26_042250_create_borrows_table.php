<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Http\Controllers\BorrowStatusConstants;

class CreateBorrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->unsignedBigInteger('library_id');
            $table->foreign('library_id')->references('id')->on('libraries')->onDelete('cascade');
//            $table->bigInteger('customer_id')->unsigned();
//            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('full_name');
            $table->string('department')->nullable();
            $table->date('date_borrowed')->nullable();
            $table->date('date_expected_returned');
            $table->date('date_actual_returned')->nullable();;
            $table->integer('status_id')->default(BorrowStatusConstants::BORROWING);
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
        Schema::dropIfExists('borrows');
    }
}
