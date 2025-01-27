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
	&settlements="{setlList}"', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('items/{shopID}/
	?page="{page}"
	&searchKey="{key}"
	&searchIn="{cat}"
	&orderBy="{orderBy}"
	&asc="{order}"
	&status="{stauts}"', function (Request $request) {
    return $request->user();
});

