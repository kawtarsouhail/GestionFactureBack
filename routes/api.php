<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FactureController;
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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/afficher', [AuthController::class, 'afficher']);

Route::post('/enregistrerFacture', [FactureController::class, 'store']);
Route::get('/getFacture', [FactureController::class, 'getDonnees']);



Route::put('/factures/{id}', [FactureController::class, 'update']); 
Route::delete('/deleteFacture/{id}', [FactureController::class, 'delete']); 

Route::put('/modifier/{id}', [AuthController::class, 'update']);
Route::delete('/supprimer/{id}', [AuthController::class, 'destroy']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});
