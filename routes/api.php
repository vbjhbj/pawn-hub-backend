<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
	&settlements="{setlList}"', [ItemController::class 'index']
);

Route::middleware('auth:sanctum')->get('items/{shopID}/
	?page="{page}"
	&searchKey="{key}"
	&searchIn="{cat}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&status="{stauts}"', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('item/{itemID}', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('shops/
	?page="{page}"
	&searchKey="{key}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&hold="{holding}"
	&settlements="{setlList}"', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('customers/{shopID}/
	?page="{page}"
	&searchKey="{key}"
	&searchIn="{searchParam}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&status="{status}"', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('shop/{userID}', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('customer/{userID}', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('customerNonuser/{customerID}', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('loans/
	?page="{page}"
	&searchKey="{key}"
	&searchIn="{searchParam}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&status="{status}"', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('loan/{loanID}', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('messages/?sender="{sId}"&receiver="{rId}"', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('message/{messageID}', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->set('item/{itemID}', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->set('shop/{userID}', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->set('loan/{loanID}', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->set('setting/{settingID}', function (Request $request) {
    return $request->user();
});