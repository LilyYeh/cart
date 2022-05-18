<?php

use Illuminate\Support\Facades\Route;

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

//購物車
Route::get('/cart', function () {
    return view('cart');
});
Route::get('/get/cart', 'Cart@get');
Route::put('/add/cart', 'Cart@add');
Route::post('/edit/cart', 'Cart@edit');
Route::delete('/delete/cart', 'Cart@delete');

//商品列表
Route::get('/get/products', 'Products@get');
