<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
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
/*
Route::middleware('auth:sanctum')->get('/items', [App\Http\Controllers\ItemController::class, 'index']);

Route::middleware('auth:sanctum')->get('items/{shopID}/
	?page="{page}"
	&searchKey="{key}"
	&searchIn="{cat}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&status="{stauts}"', [ItemController::class, 'store']);

Route::get('/item/{itemID}', [ItemController::class, 'show']);
#Route::get('/item/{itemID}', 'ItemController@show');


Route::middleware('auth:sanctum')->get('shops/
	?page="{page}"
	&searchKey="{key}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&hold="{holding}"
	&settlements="{settlList}"', [ShopController::class, 'index']);

Route::middleware('auth:sanctum')->get('customers/{shopID}/
	?page="{page}"
	&searchKey="{key}"
	&searchIn="{searchParam}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&status="{status}"', [CustomerController::class, 'index']);

Route::get('shop/{shopID}', [ShopController::class, 'show']);

Route::get('customer/{customerID}', [CustomerController::class, 'show']);

Route::middleware('auth:sanctum')->get('loans/
	?page="{page}"
	&searchKey="{key}"
	&searchIn="{searchParam}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&status="{status}"', [LoanController::class, 'index']);

Route::get('loan/{loanID}', [LoanController::class, 'show']);

Route::middleware('auth:sanctum')->get('messages/?sender="{sId}"&receiver="{rId}"', [MessageController::class, 'index']);

Route::middleware('auth:sanctum')->get('message/{messageID}', [MessageController::class, 'show']);



#-----------------------------------------------------------------------------------------

Route::middleware('auth:sanctum')->patch('/item', [ItemController::class, 'update']);

Route::put('/shop', [ShopController::class, 'update']);

Route::middleware('auth:sanctum')->patch('/loan', [LoanController::class, 'update']);

Route::middleware('auth:sanctum')->patch('/customer', [CustomerController::class, 'update']);

#-----------------------------------------------------------------------------------------------------

Route::post('/customer', [CustomerController::class, 'create']);

Route::post('/loan', [LoanController::class, 'create']);

Route::post('/shop', [ShopController::class, 'create']);

Route::post('/item', [ItemController::class, 'create']);

Route::post('/user', [UserController::class, 'create']);

Route::post('/message', [MessageController::class, 'create']);

#-------------------------------------------------------------------------------------------------------

Route::delete('/customer/{customerId}', [CustomerController::class, 'destroy']);

Route::delete('/loan/{loanId}', [LoanController::class, 'destroy']);

Route::delete('/shop/{shopId}', [ShopController::class, 'destroy']);

Route::delete('/item/{itemId}', [ItemController::class, 'destroy']);

Route::delete('/message/{messageId}', [MessageController::class, 'destroy']);*/