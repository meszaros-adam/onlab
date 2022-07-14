<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\LoginCheck;

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

//Auth
Route::post('/registration', [App\Http\Controllers\UserController::class, 'registration']);
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout']);
//Social Auth
Route::get('/social-auth/{provider}', [App\Http\Controllers\SocialController::class, 'redirect']);
Route::get('/social-auth/{provider}/callback', [App\Http\Controllers\SocialController::class, 'callback']);


Route::prefix('app')->group(function () {

    //Events
    Route::post('/create_event',  [App\Http\Controllers\EventController::class, 'add'])->middleware(AdminCheck::class);
    Route::get('/get_events',  [App\Http\Controllers\EventController::class, 'getAll']);
    Route::get('/get_events_paginated',  [App\Http\Controllers\EventController::class, 'getPaginated']);
    Route::get('/get_single_event',  [App\Http\Controllers\EventController::class, 'getSingle']);
    Route::get('/search_event',  [App\Http\Controllers\EventController::class, 'search']);
    Route::post('/delete_event',  [App\Http\Controllers\EventController::class, 'delete'])->middleware(AdminCheck::class);
    Route::post('/edit_event',  [App\Http\Controllers\EventController::class, 'edit'])->middleware(AdminCheck::class);

    //Tags
    Route::post('/create_tag',  [App\Http\Controllers\TagController::class, 'add'])->middleware(AdminCheck::class);
    Route::get('/get_tags', [App\Http\Controllers\TagController::class, 'get']);
    Route::post('/delete_tag',  [App\Http\Controllers\TagController::class, 'delete'])->middleware(AdminCheck::class);
    Route::post('/edit_tag',  [App\Http\Controllers\TagController::class, 'edit'])->middleware(AdminCheck::class);

    //Users
    Route::get('/get_users',  [App\Http\Controllers\UserController::class, 'get'])->middleware(AdminCheck::class);
    Route::post('/delete_user',  [App\Http\Controllers\UserController::class, 'delete'])->middleware(AdminCheck::class);
    Route::post('/edit_user',  [App\Http\Controllers\UserController::class, 'editByAdmin'])->middleware(AdminCheck::class);
    Route::post('/edit_user_by_user',  [App\Http\Controllers\UserController::class, 'editByUser'])->middleware(LoginCheck::class);
    Route::post('/change_password',  [App\Http\Controllers\UserController::class, 'changePassword'])->middleware(LoginCheck::class);
    Route::post('/delete_user_by_user',  [App\Http\Controllers\UserController::class, 'deleteByUser'])->middleware(LoginCheck::class);
   
    //Registration
    Route::post('/create_registration',  [App\Http\Controllers\RegistrationController::class, 'add'])->middleware(LoginCheck::class);
    Route::get('/get_registrations',  [App\Http\Controllers\RegistrationController::class, 'getAll'])->middleware(AdminCheck::class);
    Route::get('/get_user_registrations',  [App\Http\Controllers\RegistrationController::class, 'getByUser'])->middleware(LoginCheck::class);
    Route::post('/delete_registration',  [App\Http\Controllers\RegistrationController::class, 'delete'])->middleware(AdminCheck::class);
    Route::post('/edit_registration',  [App\Http\Controllers\RegistrationController::class, 'edit'])->middleware(AdminCheck::class);

    //Comment
    Route::post('/create_comment',  [App\Http\Controllers\CommentController::class, 'add'])->middleware(LoginCheck::class);
    Route::get('/get_comment_by_event', [App\Http\Controllers\CommentController::class, 'getByEvent']);
    Route::get('/get_comments',  [App\Http\Controllers\CommentController::class, 'getAll'])->middleware(AdminCheck::class);
    Route::get('/get_user_comments',  [App\Http\Controllers\CommentController::class, 'getByUser'])->middleware(LoginCheck::class);
    Route::post('/edit_comment',  [App\Http\Controllers\CommentController::class, 'edit'])->middleware(LoginCheck::class);
    Route::post('/delete_comment',  [App\Http\Controllers\CommentController::class, 'delete'])->middleware(LoginCheck::class);
});


Route::get('/',  [App\Http\Controllers\IndexController::class, 'index']);

Route::fallback([App\Http\Controllers\IndexController::class, 'index']);

