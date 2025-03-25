<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettlementController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Services\Functions;




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

/*Route::get('/test', function () {
    return response()->json(['message' => Functions::randomImg("customer")]);
});*/

Route::post('/login', [UserController::class, 'login']);


Route::get('/items', [ItemController::class, 'index']);


Route::get('/item/{itemID}', [ItemController::class, 'show']);
#Route::get('/item/{itemID}', 'ItemController@show');


Route::get('/shops', [ShopController::class, 'index'])->middleware('auth:sanctum');

Route::get('/customers', [CustomerController::class, 'index'])->middleware('auth:sanctum');

Route::get('/settlements', [SettlementController::class, 'index']);

Route::get('shop/{shopID}', [ShopController::class, 'show']);

Route::get('customer/{customerID}', [CustomerController::class, 'show']);

Route::get('/loans', [LoanController::class, 'index'])->middleware('auth:sanctum');//2

Route::get('loan/{loanID}', [LoanController::class, 'show']);

Route::get('/messages', [MessageController::class, 'index'])->middleware('auth:sanctum');

Route::get('message/{messageID}', [MessageController::class, 'show'])->middleware('auth:sanctum');



#-----------------------------------------------------------------------------------------

Route::put('/item', [ItemController::class, 'update'])->middleware('auth:sanctum');

Route::put('/shop', [ShopController::class, 'update'])->middleware('auth:sanctum');

Route::put('/loan', [LoanController::class, 'update'])->middleware('auth:sanctum');

Route::patch('/customer', [CustomerController::class, 'update'])->middleware('auth:sanctum');

#-----------------------------------------------------------------------------------------------------

Route::post('/customer', [CustomerController::class, 'create']);

Route::post('/loan', [LoanController::class, 'create']);

Route::post('/shop', [ShopController::class, 'create']);

Route::post('/item', [ItemController::class, 'create']);

Route::post('/message', [MessageController::class, 'create']);

Route::post('/ownCustomer', [CustomerController::class, 'store'])->middleware('auth:sanctum');

#-------------------------------------------------------------------------------------------------------

Route::delete('/customer/{customerId}', [CustomerController::class, 'destroy'])->middleware('auth:sanctum');

Route::delete('/loan/{loanId}', [LoanController::class, 'destroy'])->middleware('auth:sanctum');

Route::delete('/shop/{shopId}', [ShopController::class, 'destroy'])->middleware('auth:sanctum');

Route::delete('/item/{itemId}', [ItemController::class, 'destroy'])->middleware('auth:sanctum');

Route::delete('/message/{messageId}', [MessageController::class, 'destroy'])->middleware('auth:sanctum');