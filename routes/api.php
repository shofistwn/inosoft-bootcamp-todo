<?php

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
    Route::post('/show', [TodoController::class, 'showTodos']);
    Route::post('/create', [TodoController::class, 'createTodo']);
    Route::post('/update', [TodoController::class, 'updateTodo']);
    Route::post('/delete', [TodoController::class, 'deleteTodo']);
});
