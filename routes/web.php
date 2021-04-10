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
Route::get('/events/create', [App\Http\Controllers\EventsController::class, 'create' ]);
Route::get('/events/{event}/edit', [App\Http\Controllers\EventsController::class, 'edit' ]);
Route::get('/events/{event}', [App\Http\Controllers\EventsController::class, 'show' ]);
Route::put('/events/{event}', [App\Http\Controllers\EventsController::class, 'update' ]);
Route::post('/events', [App\Http\Controllers\EventsController::class, 'store' ]);
Route::delete('/events/{event}', [App\Http\Controllers\EventsController::class, 'destroy' ]);

Route::get('/registrations', [App\Http\Controllers\RegistrationsController::class, 'index' ]);
Route::get('/registrations/create/{event}', [App\Http\Controllers\RegistrationsController::class, 'create' ]);
Route::post('/registrations/{event}/{user}', [App\Http\Controllers\RegistrationsController::class, 'store' ]);
Route::get('/registrations/{registration}', [App\Http\Controllers\RegistrationsController::class, 'show' ]);
Route::get('/registrations/{registration}/edit', [App\Http\Controllers\RegistrationsController::class, 'edit' ]);
Route::put('/registrations/{registration}', [App\Http\Controllers\RegistrationsController::class, 'update' ]);
Route::delete('/registrations/{registration}', [App\Http\Controllers\RegistrationsController::class, 'destroy' ]);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
