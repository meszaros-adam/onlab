<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/events', [App\Http\Controllers\EventsController::class, 'index' ]);
Route::get('/events/create', [App\Http\Controllers\EventsController::class, 'create' ])->middleware('can:create,App\Models\Event');
Route::post('/events', [App\Http\Controllers\EventsController::class, 'store' ])->middleware('can:create,App\Models\Event');
Route::get('/events/{event}', [App\Http\Controllers\EventsController::class, 'show' ]);
Route::get('/events/{event}/edit', [App\Http\Controllers\EventsController::class, 'edit' ])->middleware('can:update,event');
Route::put('/events/{event}', [App\Http\Controllers\EventsController::class, 'update' ])->middleware('can:update,event');
Route::delete('/events/{event}', [App\Http\Controllers\EventsController::class, 'destroy' ])->middleware('can:delete,event');

Route::get('/registrations', [App\Http\Controllers\RegistrationsController::class, 'index' ])->middleware('can:viewAny, App\Models\Registration');
Route::get('/registrations/create/{event}', [App\Http\Controllers\RegistrationsController::class, 'create' ])->middleware('can:create,App\Models\Registration');
Route::post('/registrations/{event}', [App\Http\Controllers\RegistrationsController::class, 'store' ])->middleware('can:create,App\Models\Registration');
Route::get('/registrations/{registration}', [App\Http\Controllers\RegistrationsController::class, 'show' ])->middleware('can:view,registration');
Route::get('/registrations/{registration}/edit', [App\Http\Controllers\RegistrationsController::class, 'edit' ])->middleware('can:update,registration');
Route::put('/registrations/{registration}', [App\Http\Controllers\RegistrationsController::class, 'update' ])->middleware('can:update,registration');
Route::delete('/registrations/{registration}', [App\Http\Controllers\RegistrationsController::class, 'destroy' ])->middleware('can:create,registration');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
