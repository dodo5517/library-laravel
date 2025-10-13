<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowRequestController;
use App\Http\Controllers\BorrowedBookController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\CategoryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, 'index'] )->name('main.index');
Route::get('main', [MainController::class, 'index'] )->name('main.index');
// Route::get('/main/show', [MainController::class, 'show']);


Route::get('admin', [AdminController::class, 'index'])->name('admin.index');

Route::get('admin/book', [BookController::class, 'index'])->name('admin.book.index');
Route::get('admin/book/{id}/delete_file', [BookController::class, 'delete_file'])->name('admin.book.delete_file');
Route::get('admin/client', [ClientController::class, 'index'])->name('admin.client.index');
Route::get('admin/log', [BorrowRequestController::class, 'index'])->name('admin.log.index');
Route::get('admin/borrowedBook/approve/{id}', [BorrowRequestController::class, 'borrowRequestApprove'])->name('admin.borrowedBook.approve');
Route::get('admin/category', [CategoryController::class, 'index'])->name('admin.category.index');
Route::get('admin/borrowedBook', [BorrowedBookController::class, 'index'])->name('admin.borrowedBook.index');
Route::get('admin/borrowedBook/{id}', [BorrowedBookController::class, 'returnBook'])->name('admin.borrowedBook.returnBook');

Route::post('client/check',[ClientController::class,'check']);
Route::get('client/logout',[ClientController::class,'logout']);
Route::resource('client', ClientController::class);


Route::get('book/detail/{id}', [BookController::class, 'detail'])->name('book.detail');
Route::get('book/list/{category_id}', [BookController::class, 'main_index'])->name('book.main_index');
Route::get('book/search', [BookController::class, 'searchList'])->name('search');
// Route::get('book/korean', [BookController::class, 'indexKorean'])->name('book.indexKorean');
// Route::get('book/foreign', [BookController::class, 'indexForeign'])->name('book.indexForeign');
Route::get('book/myBook/{id}', [BookController::class, 'indexMyBook'])->name('book.indexMyBook');
Route::delete('book/myBook/requestCancel/{id}', [BookController::class, 'requestCancel'])->name('book.requestCancel');
Route::delete('book/myBook/wishDestroy/{id}', [BookController::class, 'wishDestroy'])->name('book.wishDestroy');

Route::get('book/wish', [WishlistController::class, 'wish'])->name('book.wish');
Route::get('book/borrow-request', [BorrowRequestController::class, 'borrowBookRequest'])->name('book.borrow');

Route::resource('book', BookController::class);
Route::resource('borrow-request', BorrowRequestController::class);

Route::resource('borrowed-book', BorrowedBookController::class);

Route::resource('category', CategoryController::class);
Route::resource('wishlist', WishlistController::class);

Route::get('log', [LogController::class, 'index'])->name('log.index');
Route::resource('log', LogController::class);
Route::resource('/',MainController::class);