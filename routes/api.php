<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShopController;

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

Route::middleware('auth:sanctum')->get('/items/
	?page="{page}"
	&searchKey="{key}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&category="{cat}"
	&minPrice={minP}
	&maxPrice={maxP}
	&hold="{holding}"
	&settlements="{setlList}"', [ItemController::class, 'index']
);

Route::middleware('auth:sanctum')->get('items/{shopID}/
	?page="{page}"
	&searchKey="{key}"
	&searchIn="{cat}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&status="{stauts}"', [ItemController::class, 'store']);

#Route::get('/item/{itemID}', [ItemController::class, 'show']);
Route::get('/item/{itemID}', 'ItemController@show');


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

Route::middleware('auth:sanctum')->get('shop/{userID}', [ShopController::class, 'show']);

Route::middleware('auth:sanctum')->get('customer/{userID}', [CustomerController::class, 'show']);

Route::middleware('auth:sanctum')->get('customerNonuser/{customerID}',  [CustomerController::class, 'show']);

Route::middleware('auth:sanctum')->get('loans/
	?page="{page}"
	&searchKey="{key}"
	&searchIn="{searchParam}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&status="{status}"', [LoanController::class, 'index']);

Route::middleware('auth:sanctum')->get('loan/{loanID}', [LoanController::class, 'show']);

Route::middleware('auth:sanctum')->get('messages/?sender="{sId}"&receiver="{rId}"', [MessageController::class, 'index']);

Route::middleware('auth:sanctum')->get('message/{messageID}', [MessageController::class, 'show']);

#-----------------------------------------------------------------------------------------

Route::middleware('auth:sanctum')->patch('item/{itemID}', [ItemController::class, 'store']);

Route::middleware('auth:sanctum')->patch('shop/{userID}', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->patch('loan/{loanID}', [LoanController::class, 'store']);

Route::middleware('auth:sanctum')->patch('setting/{settingID}', [UserController::class, 'show']);