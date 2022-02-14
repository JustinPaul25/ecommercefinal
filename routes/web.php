<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\HotDealsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\NewArrivalController;
use App\Http\Controllers\ProductViewController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\LoginRedirectController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login-redirect', [LoginRedirectController::class, 'login'])->middleware(['auth']);

Route::get('/dashboard', function () {
        return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//CATEGORIES
Route::get('/administrator/categories', function () {
    return view('backend.categories');
})->middleware(['auth'])->name('admin-categories');
Route::get('/category-selection', [CategoriesController::class, 'selection']);
Route::post('/category', [CategoriesController::class, 'store'])->middleware(['auth']);
Route::get('/get-categories', [CategoriesController::class, 'getCategories'])->middleware(['auth']);
Route::delete('/{category}/category', [CategoriesController::class, 'destroy'])->middleware(['auth']);
Route::put('/category/{category}', [CategoriesController::class, 'update'])->middleware(['auth']);

//PRODUCTS
Route::get('/administrator/products', function () {
    return view('backend.products');
})->middleware(['auth'])->name('admin-products');
Route::get('/get-products', [ProductController::class, 'getProducts'])->middleware(['auth']);
Route::post('/product', [ProductController::class, 'store'])->middleware(['auth']);
Route::put('/product/{product}', [ProductController::class, 'update'])->middleware(['auth']);
Route::put('/update-stock/{product}', [ProductController::class, 'updateStock'])->middleware(['auth']);

//PRODUCT VIEW
Route::get('/products/all-products', [ProductViewController::class, 'products'])->name('products');
Route::get('/products/hot-deals', [ProductViewController::class, 'hotDeals'])->name('hot-deals');
Route::get('/products/new-arrivals', [ProductViewController::class, 'newArrivals'])->name('new-arrivals');
Route::get('/products-list', [ProductViewController::class, 'list']);
Route::get('/product/{product}', [ProductViewController::class, 'show']);

//CART
Route::get('/cart-items', [CartController::class, 'list'])->middleware(['auth'])->name('cart');
Route::post('/add-to-cart', [CartController::class, 'store'])->middleware(['auth']);
Route::get('/my-cart', [CartController::class, 'myCart'])->middleware(['auth']);
Route::get('/my-cart-checkout', [CartController::class, 'myCartCheckout'])->middleware(['auth']);
Route::delete('/{cartItem}/my-cart', [CartController::class, 'destroyItem'])->middleware(['auth']);

//MESSAGE
Route::get('/messages', [MessageController::class, 'list'])->middleware(['auth'])->name('messages');
Route::get('/administrator/messages', [MessageController::class, 'adminList'])->middleware(['auth'])->name('admin-messages');
Route::post('/message', [MessageController::class, 'store'])->middleware(['auth']);
Route::post('/reply-message', [MessageController::class, 'storeReply'])->middleware(['auth']);

//PRODUCT IMAGE
Route::put('/product-image-delete/{product}', [ProductImageController::class, 'destroy'])->middleware(['auth']);
Route::post('/product-image-update', [ProductImageController::class, 'update'])->middleware(['auth']);

//LANDING PAGE
Route::get('/hot-deals', [HotDealsController::class, 'heroData']);
Route::get('/new-arrival', [NewArrivalController::class, 'heroData']);

//ORDERS
Route::get('/administrator/orders', [OrderController::class, 'list'])->middleware(['auth'])->name('admin-orders');
Route::get('/all-orders', [OrderController::class, 'allOrders'])->middleware(['auth']);
Route::get('/orders', [OrderController::class, 'customerOrders'])->middleware(['auth'])->name('frontend-orders');
Route::put('/cart-change-status/{cart}', [OrderController::class, 'cartChangeStatus'])->middleware(['auth']);

//REVIEWS
Route::post('/review', [ReviewsController::class, 'store'])->middleware(['auth']);

//CASHIER
Route::post('/cashier-checkout', [CashierController::class, 'checkout'])->middleware(['auth']);
Route::get('/administrator/cashier', function () {
    return view('backend.cashier');
})->middleware(['auth'])->name('cashier');

require __DIR__.'/auth.php';