<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// // });




// login
Route::post('authenticate', [AuthController::class, 'authenticate']);

// nambah user
Route::post('storeUser', [UserController::class, 'storeUser']);
Route::post('pin', [UserController::class, 'checkOut']);
Route::post('barang/{id}/kurangi-stok', [UserController::class, 'kurangiStok']); // ini awal 
Route::post('barang/{id}/kurangi-barang', [UserController::class, 'pesan']); // ini yang bagus
Route::post('barang/{id}/kurangi-stok-barang', [UserController::class, 'pesanBarang']);


// konten
Route::get('tour', [TourController::class, 'tour']);
Route::get('camp', [TourController::class, 'camp']);
Route::get('concert', [TourController::class, 'concert']);
Route::get('all', [TourController::class, 'semua']);