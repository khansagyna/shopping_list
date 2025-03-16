<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShoppingItemController;

// Route untuk registrasi dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Group route yang butuh autentikasi Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // CRUD Shopping List
    Route::get('/shopping-items', [ShoppingItemController::class, 'index']);
    Route::post('/shopping-items', [ShoppingItemController::class, 'store']);
    Route::get('/shopping-items/{id}', [ShoppingItemController::class, 'show']);
    Route::put('/shopping-items/{id}', [ShoppingItemController::class, 'update']);
    Route::delete('/shopping-items/{id}', [ShoppingItemController::class, 'destroy']);
});
