<?php

use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('currencyRatios',    [CurrencyController::class, 'index']);
Route::get('getCurrencies',     [CurrencyController::class, 'getCurrencies']);
Route::get('getCurrencyRatios', [CurrencyController::class, 'getCurrencyRatios']);
