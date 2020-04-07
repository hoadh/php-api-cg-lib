<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'AuthController@login');
Route::get('download-excel-sample', 'Api\BookController@exportExcelSample');

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('me', 'AuthController@me');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('change-password', 'Api\UserController@changePassword');

    Route::prefix('libraries')->group(function () {
        Route::get('/', 'Api\LibraryController@index');
        Route::post('/create', 'Api\LibraryController@store');
        Route::delete('/{id}/delete', 'Api\LibraryController@destroy');
        Route::post('/{id}/update', 'Api\LibraryController@update');
        Route::get('/{id}', 'Api\LibraryController@show');
//        Route::get('/{id}/books', 'Api\BookController@getBooksByLibraryId');
        Route::get('/{id}/books', 'Api\BookController@filterBooks');
        Route::delete('{library_id}/books/{id}', 'Api\BookController@destroy');
        Route::get('{library_id}/books/{id}', 'Api\BookController@show');
        Route::put('{library_id}/books/{id}', 'Api\BookController@update');
        Route::get('/{library_id}/books/borrow-status/{statusBorrow}', 'Api\BookController@getBookByStatusBorrow');

        Route::post('/{library_id}/borrows', 'Api\BorrowController@store');
        Route::get('/{library_id}/borrows', 'Api\BorrowController@index');
        Route::get('/{library_id}/borrows/{id}', 'Api\BorrowController@show');
        Route::put('/{library_id}/borrows/{id}', 'Api\BorrowController@update');
        Route::post('/{library_id}/books/import', 'Api\BookController@importBooksFromFile')->name('import');

        Route::get('/{library_id}/customers', 'Api\CustomerController@index')->name('customer.index');
        Route::get('/{library_id}/customers/{customer_id}', 'Api\CustomerController@show')->name('customer.show');
        Route::post('/{library_id}/customers', 'Api\CustomerController@store')->name('customer.store');
        Route::put('/{library_id}/customers/{customer_id}', 'Api\CustomerController@update')->name('customer.update');
        Route::delete('/{library_id}/customers/{customer_id}', 'Api\CustomerController@delete')->name('customer.delete');
    });

    Route::prefix('librarians')->group(function () {
        Route::get('/', 'Api\UserController@index');
        Route::post('/create', 'Api\UserController@store');
        Route::delete('/{id}/delete', 'Api\UserController@destroy');
        Route::post('/{id}/update', 'Api\UserController@update');
        Route::get('/{id}', 'Api\UserController@show');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', 'Api\CategoryController@index');
        Route::post('/', 'Api\CategoryController@store');
        Route::delete('/{id}', 'Api\CategoryController@destroy');
        Route::put('/{id}', 'Api\CategoryController@update');
    });

    Route::prefix('books')->group(function () {
        Route::post('/', 'Api\BookController@store');
        Route::get('/', 'Api\BookController@index');
        Route::get('filter/', 'Api\BookController@getBooksByFields');
    });

    Route::prefix('stats')->group(function () {
        Route::get('/borrow-return', 'Api\BorrowController@filter');
    });

});

