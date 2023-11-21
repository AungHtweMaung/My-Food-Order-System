<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;

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


// login, register
// if user authenticated, that user can't go to login or register page
Route::middleware(['admin_auth', 'user_auth'])->group(function () {
    Route::redirect('/', 'loginPage');
    Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});


// we use laravel auth, so we can use logout, login by default
Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', [AuthController::class, 'dashboard'])->name("dashboard");

    // admin
    Route::middleware(['admin_auth'])->group(function () {
        // category
        Route::group(['prefix' => 'category'], function () {
            Route::get('list', [CategoryController::class, 'list'])->name('category#list');
            Route::get('create/page', [CategoryController::class, 'createPage'])->name('category#createPage');
            Route::post('create', [CategoryController::class, 'create'])->name('category#create');
            Route::get('edit/{id}', [CategoryController::class, 'editPage'])->name('category#editPage');
            Route::post('update/{id}', [CategoryController::class, 'update'])->name('category#update');
            Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
        });

        // product
        Route::group(['prefix' => 'products'], function () {
            Route::get('list', [ProductController::class, 'list'])->name('product#list');
            Route::get('create', [ProductController::class, 'createPage'])->name('product#createPage');
            Route::post('create', [ProductController::class, 'create'])->name('product#create');
            Route::get('delete/{id}', [ProductController::class, 'delete'])->name('product#delete');
            Route::get('detail/{id}', [ProductController::class, 'detail'])->name('product#detail');
            Route::get('edit/{id}', [ProductController::class, 'editPage'])->name('product#editPage');
            Route::post('update/{id}', [ProductController::class, 'update'])->name('product#update');
        });

        // order
        Route::prefix('order')->group(function(){
            Route::get('list', [OrderController::class, 'list'])->name('order#list');
            Route::get('productList/{orderCode}', [OrderController::class, 'productList'])->name('order#productList');
            // ajax order status
            Route::get('filter/orderStatus', [OrderController::class, 'orderStatus'])->name('order#status');
            Route::get('ajax/changeStatus', [OrderController::class, 'changeStatus'])->name('order#changestatus');

        });

        // user contact message
        Route::prefix('contact')->group(function () {
            Route::get('list', [AdminController::class, 'contactList'])->name('admin#userContactList');
            Route::get('{id}', [AdminController::class, 'contactMessage'])->name('admin#userMessageDetail');
        });

        // account
        Route::prefix('admin')->group(function () {
            // password
            Route::get('password/changePage', [AdminController::class, 'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('change/password', [AdminController::class, 'changePassword'])->name('admin#changePassword');

            // profile
            Route::get('detail', [AdminController::class, 'detail'])->name('admin#detail');
            Route::get('edit', [AdminController::class, 'edit'])->name('admin#edit');
            Route::post('update/{id}', [AdminController::class, 'update'])->name('admin#update');
            Route::get('list/', [AdminController::class, 'adminList'])->name('admin#list');
            Route::get('delete/{id}', [AdminController::class, 'delete'])->name('admin#delete');

            // user list
            Route::get('normalUser/list', [AdminController::class, 'normalUserList'])->name('admin#normalUserList');
            Route::get('normalUser/{id}/delete', [AdminController::class, 'deleteNormalUser'])->name('admin#deleteNormalUser');
            // Route::get('roleChange/{id}', [AdminController::class, 'roleChangePage'])->name('admin#roleChangePage');
            Route::get('ajax/admin/roleChange', [AdminController::class, 'roleChange'])->name('admin#roleChange');
            Route::get('ajax/user/roleChange', [AdminController::class, 'userRoleChange'])->name('admin#userRoleChange');
        });
    });

    // user
    Route::group(["prefix" => "user", "middleware" => "user_auth"], function () {
        Route::get('home/', [UserController::class, 'home'])->name("user#home");
        Route::get('filter/category/{id}', [UserController::class, 'filterByCategory'])->name('user#filterByCategory');
        Route::get('history', [UserController::class, 'history'])->name('user#history');

        // products
        Route::prefix('products')->group(function() {
            Route::get('details/{id}', [UserController::class, 'productDetails'])->name('user#productDetails');

        });

        // cart
        Route::group(['prefix'=>'cart'], function () {
            Route::get('list/', [UserController::class, 'cartList'])->name('user#cartList');
        });

        // password
        Route::get('password/changePage', [UserController::class, 'changePasswordPage'])->name('user#changePasswordPage');
        Route::post('password/change', [UserController::class, 'changePassword'])->name('user#changePassword');

        // profile
        Route::prefix('profile')->group(function () {
            Route::get('detail', [UserController::class, 'profileDetail'])->name("user#profileDetail");
            Route::get('edit/{id}', [UserController::class, 'editPage'])->name('user#editPage');
            Route::post('update/{id}', [UserController::class, 'update'])->name('user#update');
        });

        // contact
        Route::prefix('contact')->group(function () {
            Route::get('userContact', [ContactController::class, 'userContact'])->name('user#userContact');
            Route::post('sendMessage', [ContactController::class, 'sendMessage'])->name('user#sendMessage');
        });

        // ajax test
        Route::prefix('ajax')->group(function(){
            Route::get('/productList', [AjaxController::class, 'productList'])->name('ajax#productList');
            Route::get('/addToCart', [AjaxController::class, 'addToCart'])->name('ajax#addToCart');
            Route::get('product/{id}/increaseViewCount', [AjaxController::class, 'increaseViewCount'])->name('ajax#increaseViewCount');
            Route::get('/order', [AjaxController::class, 'order'])->name('ajax#order');
            Route::get('update/product-qty', [AjaxController::class, 'updateProductQty'])->name("ajax#updateProductQty");
            Route::get('remove/cart-item', [AjaxController::class, 'removeCartItem'])->name('ajax#removeCartItem');
            Route::get('clear/cart', [AjaxController::class, 'clearCart'])->name('ajax#clearCart');
        });


    });
});


