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

Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::put('/modifier/{id}', [AuthController::class, 'update'])->middleware('checkrole:Super Admin|edit_users');
    Route::delete('/supprimer/{id}', [AuthController::class, 'destroy'])->middleware('checkrole:Super Admin|delete_users');
    Route::get('/afficher', [AuthController::class, 'afficher'])->middleware('checkrole:Super Admin|view_all_users');
    Route::post('/register', [AuthController::class, 'register'])->middleware('checkrole:Super Admin|create_users');

});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::delete('/deleteFacture/{id}', [FactureController::class, 'delete'])->middleware('checkrole:Super Admin|Admin|delete_factures');
    Route::post('/enregistrerFacture', [FactureController::class, 'store'])->middleware('checkrole:Super Admin|Admin| create_factures');
    Route::PATCH('/factures/{id}', [FactureController::class, 'update'])->middleware('checkrole:Super Admin|Admin| edit_factures');

});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/getFacture', [FactureController::class, 'getDonnees'])->middleware('checkrole:Super Admin|Admin|Utilisateur|view_all_factures');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']); 
});