<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentsCT;
use App\Http\Controllers\UserCT;
use Illuminate\Http\Request;

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
Route::get('/order', [OrderController::class, 'showAll']);
Route::get('/order/{id}', [OrderController::class, 'show']);
Route::get('/user', [UserCT::class, 'showAll']);
Route::get('/user/{id}', [UserCT::class, 'show']);
Route::post('/payments', [PaymentsCT::class, 'create']);
Route::post('/webhooks/midtrans', [PaymentsCT::class, 'webhook']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/test', function() {
    return 'Route is working!';
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// })