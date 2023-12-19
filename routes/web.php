<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\contackController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\dataOrderController;
use App\Http\Controllers\adminIndexController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\adminTablesController;
use App\Http\Controllers\adminMasukanController;

Auth::routes();
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
Route::get('/shop/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');
Route::get('/cart/checkout', [CheckoutController::class, 'checkout'])->name('product.checkout');
Route::post('/process/checkout', [CheckoutController::class, 'processCheckout'])->name('processCheckout');
Route::get('/get-provinces', [CheckoutController::class, 'getProvinces'])->name('getProvinces');
Route::get('/get-regencies/{province_id}', [CheckoutController::class, 'getRegencies'])->name('getRegencies');
Route::get('/get-districts/{regency_id}', [CheckoutController::class, 'getDistricts'])->name('getDistricts');
Route::get('/get-villages/{district_id}', [CheckoutController::class, 'getVillages'])->name('getVillages');
Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::get('/cart/add/{id}', [CartController::class, 'store'])->name('addCart');
Route::delete('/destroyCart/{id}', [CartController::class, 'destroy'])->name('destroyCart');
Route::get('/confirmation', [CartController::class, 'confirmation'])->name('confirmation');
Route::get('/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');
Route::get('/wishlist/add/{id}', [WishlistController::class, 'store'])->name('addWishlist');
Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('destroyWishlist');
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::get('/history', [HistoryController::class, 'history'])->name('history');
Route::get('/history/detail/{id}', [HistoryController::class, 'detail'])->name('detailHistory');

//route for admin
Route::get('/indexadmin', [adminIndexController::class, 'index'])->name('indexadmin');
Route::get('/indextables', [adminTablesController::class, 'index'])->name('tableadmin');
Route::resource('user', adminTablesController::class);
//barang dari admin
Route::get('/data-barang', [ItemController::class, 'item'])->name('dataItem');
Route::get('/tambah-barang', [ItemController::class, 'create'])->name('createItem');
Route::post('/barang/store', [ItemController::class, 'store'])->name('storeItem');
Route::get('/barang/{id}/edit', [ItemController::class, 'edit'])->name('editItem');
Route::put('/barang/{id}', [ItemController::class, 'update'])->name('updateItem');
Route::delete('/barang/{id}', [ItemController::class, 'destroy'])->name('destroyItem');
//data order untuk admin
Route::get('/data-order', [dataOrderController::class, 'order'])->name('dataOrder');
Route::post('/data-order/update-status', [dataOrderController::class, 'updateStatus'])->name('dataOrder.updateStatus');
Route::get('/data-order/{id}', [dataOrderController::class, 'detail'])->name('detailOrder');
//route for contack
Route::resource('/contack', contackController::class);
Route::resource('/masukan', adminMasukanController::class);
