<?php

use App\Http\Controllers\HoldingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettlementController;
use App\Http\Controllers\TypeGroupController;
use App\Http\Controllers\TypeController;
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

Route::get('/items', [ItemController::class, 'index']);
Route::get('/shopAllItems', [ItemController::class, 'authIndex'])->middleware('auth:sanctum');

Route::get('/shops', [ShopController::class, 'index']);

Route::get('/settlements', [SettlementController::class, 'index']);

Route::get('/holdings', [HoldingController::class, 'index']);

Route::get('types', [TypeController::class, 'index']);

Route::get('/messages', [MessageController::class, 'index'])->middleware('auth:sanctum');

Route::get('/customers', [CustomerController::class, 'index'])->middleware('auth:sanctum');

Route::get('/loans', [LoanController::class, 'index'])->middleware('auth:sanctum');

Route::get('/settlement/{settlementID}', [SettlementController::class, 'show']);

Route::get('/item/{itemID}', [ItemController::class, 'show']);

Route::get('/shop/{shopID}', [ShopController::class, 'show']);

Route::get('/customer/{customerID}', [CustomerController::class, 'show'])->middleware('auth:sanctum');

Route::get('/loan/{loanID}', [LoanController::class, 'show'])->middleware('auth:sanctum');

Route::get('/message/{messageID}', [MessageController::class, 'show'])->middleware('auth:sanctum');

#-----------------------------------------------------------------------------------------

Route::patch('/item', [ItemController::class, 'update'])->middleware('auth:sanctum');

Route::patch('/shop', [ShopController::class, 'update'])->middleware('auth:sanctum');

Route::patch('/customer', [CustomerController::class, 'update'])->middleware('auth:sanctum');

#-----------------------------------------------------------------------------------------------------

Route::post('/login', [UserController::class, 'login']);

Route::post('/customer', [CustomerController::class, 'create']);

Route::post('/loan', [LoanController::class, 'create'])->middleware('auth:sanctum');

Route::post('/shop', [ShopController::class, 'create']);

Route::post('/item', [ItemController::class, 'create'])->middleware('auth:sanctum');

Route::post('/message', [MessageController::class, 'create'])->middleware('auth:sanctum');

Route::post('/ownCustomer', [CustomerController::class, 'store'])->middleware('auth:sanctum');

#-------------------------------------------------------------------------------------------------------

Route::delete('/customer/{customerId}', [CustomerController::class, 'destroy'])->middleware('auth:sanctum');

Route::delete('/loan/{loanId}', [LoanController::class, 'destroy'])->middleware('auth:sanctum');

Route::delete('/shop', [ShopController::class, 'destroy'])->middleware('auth:sanctum');

Route::delete('/item/{itemId}', [ItemController::class, 'destroy'])->middleware('auth:sanctum');

Route::delete('/message/{messageId}', [MessageController::class, 'destroy'])->middleware('auth:sanctum');