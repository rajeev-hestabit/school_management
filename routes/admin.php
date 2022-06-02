<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:api', 'isAdmin'])->group(function () {
    // Delete User
    Route::put('delete_user/{user_id}', [AdminController::class, 'delete']);
    // Get Users for approval
    Route::get('get_users_for_approval/{user_type}', [
        AdminController::class,
        'get_users_for_approval',
    ]);
    // Approve User
    Route::put('approve_user/{user_id}', [
        AdminController::class,
        'approve_user',
    ]);
    // Approve All Users
    Route::put('approve_all_users', [
        AdminController::class,
        'approve_all_users',
    ]);
    // Assign Teacher
    Route::put('assign_teacher', [AdminController::class, 'assign_teacher']);

    // Search
    Route::get('get_users/{user_type}', [AdminController::class, 'get_users']);
    Route::get('get_user/{user_id}', [AdminController::class, 'get_user']);
    //Search
    // Route::get('search/{name}', [SearchController::class, 'Search']);
});
