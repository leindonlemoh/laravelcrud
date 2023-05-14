<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LaravelUserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get("/users", [LaravelUserController::class,"index"]);
Route::post("/user", [LaravelUserController::class,"store"]);
Route::post("/user/login", [LaravelUserController::class,"login"]);
Route::post("/user/{id}", [LaravelUserController::class,"update"]);
Route::get("/user/{id}",[LaravelUserController::class,"show"]);
Route::delete("/user/{id}",[LaravelUserController::class,"destroy"]);