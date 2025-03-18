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

Route::post('/login', [UserController::class, 'login']);

Route::get('/items', [ItemController::class, 'index']);//1

Route::get('/item/{itemID}', [ItemController::class, 'show']);
#Route::get('/item/{itemID}', 'ItemController@show');


Route::middleware('auth:sanctum')->get('shops/
	?page="{page}"
	&searchKey="{key}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&hold="{holding}"
	&settlements="{settlList}"', [ShopController::class, 'index']);//2

Route::middleware('auth:sanctum')->get('/customers', [CustomerController::class, 'index']);

Route::get('/settlements', [SettlementController::class, 'index']);

Route::get('shop/{shopID}', [ShopController::class, 'show']);

Route::get('customer/{customerID}', [CustomerController::class, 'show']);

Route::middleware('auth:sanctum')->get('loans/
	?page="{page}"
	&searchKey="{key}"
	&searchIn="{searchParam}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&status="{status}"', [LoanController::class, 'index']);//3

Route::get('loan/{loanID}', [LoanController::class, 'show']);

Route::middleware('auth:sanctum')->get('/messages', [MessageController::class, 'index']);//4

Route::middleware('auth:sanctum')->get('message/{messageID}', [MessageController::class, 'show']);



#-----------------------------------------------------------------------------------------

Route::middleware('auth:sanctum')->put('/item', [ItemController::class, 'update']);

Route::put('/shop', [ShopController::class, 'update'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->put('/loan', [LoanController::class, 'update']);

Route::middleware('auth:sanctum')->put('/customer', [CustomerController::class, 'update']);

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