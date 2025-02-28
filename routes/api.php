<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;




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

Route::middleware('auth:sanctum')->patch('/item/{itemID}', [ItemController::class, 'update']);

Route::patch('/shop/{shopID}', [ShopController::class, 'update']);

Route::middleware('auth:sanctum')->patch('/loan/{loanID}', [LoanController::class, 'update']);

Route::middleware('auth:sanctum')->patch('/customer/{customerID}', [CustomerController::class, 'update']);

#-----------------------------------------------------------------------------------------------------

Route::post('/customer', [CustomerController::class, 'create']);

Route::post('/loan', [LoanController::class, 'create']);

Route::post('/shop', [ShopController::class, 'create']);

Route::post('/item', [ItemController::class, 'create']);

Route::post('/user', [UserController::class, 'create']);

Route::post('/message', [MessageController::class, 'create']);

#-------------------------------------------------------------------------------------------------------

Route::delete('/customer', [CustomerController::class, 'delete']);

Route::delete('/loan', [LoanController::class, 'delete']);

Route::delete('/shop', [ShopController::class, 'delete']);

Route::delete('/item', [ItemController::class, 'delete']);

Route::delete('/message', [MessageController::class, 'delete']);