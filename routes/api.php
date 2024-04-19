<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UtilisateurController;
use App\Http\Controllers\api\VerificationController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/posts', 'api/PostController@index');


Route::post('/login', [UtilisateurController::class, 'login']);

//Route::post('/verifier', [VerificationController::class, 'verifierValeur']);
Route::post('/verifier', [VerificationController::class, 'verifierValeur']); 