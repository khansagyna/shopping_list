<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingItemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini kita mendefinisikan semua route untuk API.
| Semua route dalam file ini akan otomatis memiliki prefix "/api".
|
*/

// Route default untuk cek API berjalan
Route::get('/', function () {
    return response()->json(['message' => 'Welcome to Shopping List API!'], 200);
});

// Route untuk Shopping List (CRUD)
Route::apiResource('shopping-items', ShoppingItemController::class);