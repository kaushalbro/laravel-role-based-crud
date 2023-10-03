<?php

use App\Http\Controllers\ActivityLog;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\userProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('activity_log', ActivityLog::class);
    Route::resource('tasks', TaskController::class);
    Route::patch('update_task/{task}/{status}', [TaskController::class, 'setStatus'])->name('status.update');
    Route::get('/user/{user_id}/tasks/', [TaskController::class, 'getUserTask']);
    Route::post('/task_review/{task_id}/{status}/message={message}/', [TaskController::class, 'setTaskReview']);
    
    Route::group(['middleware' => ['isCurrentUser']], function () {
        Route::get('/users/{user_id}/profile', [userProfileController::class, 'show'])->name('profile.show');
        Route::get('/users/{user_id}/profile/edit', [userProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/users/{user_id}/profile', [userProfileController::class, 'update'])->name('profile.update');
    });
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
