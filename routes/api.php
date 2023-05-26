<?php

use App\Models\Order;
use App\Events\SuccessOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductImageController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::controller(CustomerController::class)->group( function() {
    Route::post('/customer/store', 'store');
    Route::get('/customer/{id}', 'show');
 });*/

Route::resource('customer',CustomerController::class);
Route::resource('product',ProductController::class);
Route::resource('order',OrderController::class);
Route::get('product-images/{id}',[ProductImageController::class,'index']);
Route::get('product-image/{id}',[ProductImageController::class,'show']);
Route::post('product-image-add/{id}',[ProductImageController::class,'store']);
Route::post('product-image-update/{id}',[ProductImageController::class,'update']);
Route::post('product-image-delete/{id}',[ProductImageController::class,'destroy']);

Route::patch('order/update-status/{id}',[OrderController::class,'update_status']);
Route::patch('order/update-shipping-date/{id}',[OrderController::class,'update_shipping_date']);
Route::get('customer-order/{id}',[CustomerController::class,'customer_order']);

Route::post('product/add-image',[ProductController::class,'add_product_image']);
Route::post('product/update-image',[ProductController::class,'update_product_image']);
Route::delete('product/delete-image/{id}',[ProductController::class,'delete_product_image']);

Route::get('get-product-visits/{id}',[ProductController::class,'get_product_visits']);
Route::get('get-product-price/{id}',[ProductController::class,'get_product_price']);


Route::controller(AuthController::class)->group(function()
{
    Route::post('register','register');
    Route::post('login', 'login');
});

/*Route::middleware('jwt.auth')->post('/logout', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => 'jwt.auth'], function () {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('get-user', [AuthController::class, 'getUser']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('edit-profile', [AuthController::class, 'edit_profile']);
    Route::post('change-password', [AuthController::class, 'change_password']);
});

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*Route::patch('order/update-status/{id}',function(){
    $order = Order::find(1);
    //dd($order);
    event(new SuccessOrder($order));
});*/
