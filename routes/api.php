<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    TodoController
};

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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'todo'
], function () {
    Route::get('/show', [TodoController::class, 'index']);
    Route::post('/create', [TodoController::class, 'store']);
    Route::put('/update', [TodoController::class, 'update']);
    Route::delete('/delete', [TodoController::class, 'delete']);
});
