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

//Admin
Route::prefix('admin')->middleware(AdminCheck::class)->group(function () {
    Route::get('/events',  [App\Http\Controllers\IndexController::class, 'index']);
    Route::get('/tags',  [App\Http\Controllers\IndexController::class, 'index']);
    Route::get('/users',  [App\Http\Controllers\IndexController::class, 'index']);
    Route::get('/registrations',  [App\Http\Controllers\IndexController::class, 'index']);
});

//Auth
Route::post('/registration', [App\Http\Controllers\UserController::class, 'registration']);
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout']);

Route::prefix('app')->group(function () {

    //Events
    Route::post('/create_event',  [App\Http\Controllers\EventController::class, 'add'])->middleware(AdminCheck::class);
    Route::get('/get_events',  [App\Http\Controllers\EventController::class, 'getAll']);
    Route::get('/get_actual_events',  [App\Http\Controllers\EventController::class, 'getActual']);
    Route::get('/get_earlier_events',  [App\Http\Controllers\EventController::class, 'getEarlier']);
    Route::post('/delete_event',  [App\Http\Controllers\EventController::class, 'delete'])->middleware(AdminCheck::class);
    Route::post('/edit_event',  [App\Http\Controllers\EventController::class, 'edit'])->middleware(AdminCheck::class);

    //Tags
    Route::post('/create_tag',  [App\Http\Controllers\TagController::class, 'add'])->middleware(AdminCheck::class);
    Route::get('/get_tags', [App\Http\Controllers\TagController::class, 'get']);
    Route::get('/get_all_tags', [App\Http\Controllers\TagController::class, 'getAll']);
    Route::post('/delete_tag',  [App\Http\Controllers\TagController::class, 'delete'])->middleware(AdminCheck::class);
    Route::post('/edit_tag',  [App\Http\Controllers\TagController::class, 'edit'])->middleware(AdminCheck::class);

    //Users
    Route::get('/get_users',  [App\Http\Controllers\UserController::class, 'get'])->middleware(AdminCheck::class);
    Route::post('/delete_user',  [App\Http\Controllers\UserController::class, 'delete'])->middleware(AdminCheck::class);
    Route::post('/edit_user',  [App\Http\Controllers\UserController::class, 'edit'])->middleware(AdminCheck::class);
   
    //Registration
    Route::post('/create_registration',  [App\Http\Controllers\RegistrationController::class, 'add'])->middleware(LoginCheck::class);
});


Route::get('/',  [App\Http\Controllers\IndexController::class, 'index']);

Route::any('{slug}',  [App\Http\Controllers\IndexController::class, 'index']);


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
