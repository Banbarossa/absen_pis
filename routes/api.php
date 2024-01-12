<?php

use App\Http\Controllers\Api\RombelController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('rombel', [RombelController::class, '__invoke']);

Route::get('rombel', [RombelController::class, 'getAllRombel']);
Route::get('rombel/{id}', [RombelController::class, 'getRombel']);
