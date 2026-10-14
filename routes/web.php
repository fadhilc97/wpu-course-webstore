<?php

use App\Models\SalesOrder;
use App\Data\SalesOrderData;
use App\Mail\SalesOrderCreatedMail;
use App\Livewire\Cart;
use App\Livewire\ProductCatalog;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Livewire\Checkout;
use App\Livewire\HomePage;
use App\Livewire\SalesOrderDetail;

Route::get('/', HomePage::class)->name('home');
Route::get('/products', ProductCatalog::class)->name('product-catalog');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('product');
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/order-confirmed/{sales_order:trx_id}', SalesOrderDetail::class)->name('order-confirmed');
Route::view('/page', 'pages.page')->name('page');

Route::get('/mailable', function() {
    $latest_sales_order = SalesOrder::latest()->first();
    $latest_sales_order_data = SalesOrderData::from($latest_sales_order);
    return new SalesOrderCreatedMail($latest_sales_order_data);
});
