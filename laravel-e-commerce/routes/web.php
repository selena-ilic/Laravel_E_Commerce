<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Frontend\CheckoutController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [FrontendController::class, 'index']);
Route::get('category', [FrontendController::class, 'category']);
Route::get('view-category/{slug}', [FrontendController::class, 'viewcategory']);
Route::get('category/{category_slug}/{product_slug}', [FrontendController::class, 'productview']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('add-to-cart', [CartController::class, 'addProduct']);
Route::post('delete-cart-item', [CartController::class, 'deleteProduct']);
Route::post('update-cart', [CartController::class, 'updateCart']);

Route::middleware(['auth'])->group( function () {
    Route::get('cart', [CartController::class, 'viewcart']);
    Route::get('checkout', [CheckoutController::class, 'index']);
    Route::post('place-order', [CheckoutController::class, 'placeorder']);
});


//Route::group(['middleware' => ['auth', 'isAdmin']], function () {
//
//    Route::get('/dashboard', function () {
//        // return view('admin.dashboard');
//        return 'This is Admin';
//    });
//
//});

Route::middleware(['auth', 'isAdmin'])->group(function () {

//    Route::get('/dashboard', function () {
//         return view('admin.index');
//    });

    Route::get('/dashboard', 'Admin\FrontendController@index' );

    Route::get('/categories', 'Admin\CategoryController@index' );
    Route::get('/add-category', 'Admin\CategoryController@add' );
    Route::post('/insert-category', 'Admin\CategoryController@insert' );
    Route::get('/edit-category/{id}', [CategoryController::class, 'edit'] );
    Route::put('/update-category/{id}', [CategoryController::class, 'update'] );
    Route::get('/delete-category/{id}', [CategoryController::class, 'destroy'] );

    Route::get('/products', 'Admin\ProductController@index' );
    Route::get('/add-product', 'Admin\ProductController@add' );
    Route::post('/insert-product', 'Admin\ProductController@insert' );
    Route::get('/edit-product/{id}', [ProductController::class, 'edit'] );
    Route::put('/update-product/{id}', [ProductController::class, 'update'] );
    Route::get('/delete-product/{id}', [ProductController::class, 'destroy']);
});

