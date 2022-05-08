<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;

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

//Mainapp
Route::get('/', function () {
    return view('mainapp');
});

//Auth
Route::post('/registration', [App\Http\Controllers\UserController::class, 'registration']);
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout']);

//Events
Route::post('/create_event',  [App\Http\Controllers\EventController::class, 'add']);
Route::get('/get_events',  [App\Http\Controllers\EventController::class, 'get']);
Route::get('/get_events_by_date',  [App\Http\Controllers\EventController::class, 'getByDate']);
Route::post('/delete_event',  [App\Http\Controllers\EventController::class, 'delete']);
Route::post('/edit_event',  [App\Http\Controllers\EventController::class, 'edit']);





Route::any('{slug}',function () {
    return view('mainapp');
});


/*
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

Route::get('/users', [App\Http\Controllers\UsersController::class, 'index' ])->middleware('can:viewAny, App\Models\User');
Route::get('/home', [App\Http\Controllers\UsersController::class, 'home'])->name('home');
Route::get('/users/{user}', [App\Http\Controllers\UsersController::class, 'show' ])->middleware('can:view, App\Models\User');
Route::get('/users/{user}/registrations', [App\Http\Controllers\UsersController::class, 'registrations' ])->middleware('can:view, App\Models\User');
Route::delete('/users/{user}', [App\Http\Controllers\UsersController::class, 'destroy' ])->middleware('can:delete, App\Models\User');

Route::get('auth/{provider}', [App\Http\Controllers\SocialController::class, 'redirect']);
Route::get('auth/{provider}/callback', [App\Http\Controllers\SocialController::class, 'callback']);
Auth::routes();
*/








