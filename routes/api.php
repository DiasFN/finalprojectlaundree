<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserCT;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [UserCT::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/order', [OrderController::class, 'store']);

Route::get('/test', function() {
    return 'Route is working!';
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// })