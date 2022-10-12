<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    TaskController
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
    'prefix' => 'task'
], function () {
    Route::get('/show', [TaskController::class, 'showTasks']);
    Route::post('/create', [TaskController::class, 'createTask']);
    Route::post('/update', [TaskController::class, 'updateTask']);
    Route::post('/delete', [TaskController::class, 'deleteTask']);
});
