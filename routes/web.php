<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CarteleraController;
use App\Http\Controllers\Backend\PriceController;
use App\Http\Controllers\Backend\RatingController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\SalesController;
use App\Http\Controllers\Backend\SessionController;
use App\Http\Controllers\Backend\TicketController;
use App\Http\Controllers\Backend\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cartelera', [HomeController::class, 'cartelera'])->name('cartelera');
Route::get('/peliculas/{peli}', [HomeController::class, 'pelicula'])->name('pelicula.detallada');
Route::post('/cartelera/buscar', [HomeController::class, 'buscarSesion'])->name('buscar.sesion');
Route::get('/sobremi', [HomeController::class, 'sobremi'])->name('sobremi');

Route::get('/lang/{language}', function ($language) {
    Session::put('language', $language);
    return redirect()->back();
})->name('language');


// Registro de usuarios
Auth::routes();

// Rutas de Verificar Email
Route::get('email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect(route('home'));
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


// Usuarios Logeados
Route::group(['middleware' => 'auth', 'middleware' => 'verified'], function () {

    // USUARIO Frontend
    Route::get('user/config', [UserController::class, 'perfil'])->name('users.config');
    Route::put('user/perfil/{usuario}', [UserController::class, 'update'])->name('users.update');
    Route::put('user/contra/{usuario}', [UserController::class, 'cambiarContra'])->name('users.cambiarcontra');
    Route::get('user/compras', [UserController::class, 'compras'])->name('users.compras');
    Route::get('/pelicula/sesion/{sesion}', [UserController::class, 'buySesion'])->name('buy.sesion');
    Route::post('/pelicula/valoracion', [UserController::class, 'addValoracion'])->name('add.valoracion');
    Route::get('/user/entradas/{venta}', [UserController::class, 'exportEntradas'])->name('descargar.entradas');


    // Rutas PAYPAL
    Route::post('/paypal/pay', [PaymentController::class, 'pagarPaypal'])->name('paypal.pagar');
    Route::get('/paypal/status', [PaymentController::class, 'statusPaypal'])->name('paypal.status');
    Route::get('/paypal/cancel/{venta}', [PaymentController::class, 'devolverPaypal'])->name('paypal.cancel');

});


// Usuarios Administradores
Route::group(['middleware' => 'admin'], function () {
    
    // BACKEND
    Route::get('admin', [BackendController::class, 'index'])->name('backend');

    // BACKEND Users
    Route::get('admin/users', [UsersController::class, 'index'])->name('admin.users');
    Route::get('admin/users/list', [UsersController::class, 'getUsuarios'])->name('admin.users.list');
    Route::get('admin/users/create', [UsersController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users', [UsersController::class, 'store'])->name('admin.users.store');
    Route::get('admin/users/{usuario}', [UsersController::class, 'show'])->name('admin.users.show');
    Route::get('admin/users/edit/{usuario}', [UsersController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{usuario}', [UsersController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{usuario}', [UsersController::class, 'destroy'])->name('admin.users.destroy');

    // BACKEND Rooms
    Route::get('admin/rooms', [RoomController::class, 'index'])->name('admin.rooms');
    Route::get('admin/rooms/create', [RoomController::class, 'create'])->name('admin.rooms.create');
    Route::post('admin/rooms', [RoomController::class, 'store'])->name('admin.rooms.store');
    Route::get('admin/rooms/{sala}', [RoomController::class, 'show'])->name('admin.rooms.show');
    Route::get('admin/rooms/edit/{sala}', [RoomController::class, 'edit'])->name('admin.rooms.edit');
    Route::put('admin/rooms/{sala}', [RoomController::class, 'update'])->name('admin.rooms.update');
    Route::delete('admin/rooms/{sala}', [RoomController::class, 'destroy'])->name('admin.rooms.destroy');

    // BACKEND Cartelera
    Route::get('admin/carteleras', [CarteleraController::class, 'index'])->name('admin.carteleras');
    Route::get('admin/carteleras/create', [CarteleraController::class, 'create'])->name('admin.carteleras.create');
    Route::post('admin/carteleras', [CarteleraController::class, 'store'])->name('admin.carteleras.store');
    Route::get('admin/carteleras/{cartelera}', [CarteleraController::class, 'show'])->name('admin.carteleras.show');
    Route::get('admin/carteleras/edit/{cartelera}', [CarteleraController::class, 'edit'])->name('admin.carteleras.edit');
    Route::put('admin/carteleras/{cartelera}', [CarteleraController::class, 'update'])->name('admin.carteleras.update');
    Route::delete('admin/carteleras/{cartelera}', [CarteleraController::class, 'destroy'])->name('admin.carteleras.destroy');
    // Cartelera Peliculas
    Route::post('admin/movie/search', [MovieController::class, 'searchPeliculas'])->name('admin.carteleras.search');
    Route::get('admin/movie/popular', [MovieController::class, 'getPeliculas'])->name('admin.carteleras.popular');
    Route::get('admin/movie/{peli}', [MovieController::class, 'getPelicula'])->name('admin.carteleras.one');

    // BACKEND Sessions
    Route::get('admin/sessions', [SessionController::class, 'index'])->name('admin.sessions');
    Route::get('admin/sessions/create', [SessionController::class, 'create'])->name('admin.sessions.create');
    Route::post('admin/sessions', [SessionController::class, 'store'])->name('admin.sessions.store');
    Route::get('admin/sessions/{sesion}', [SessionController::class, 'show'])->name('admin.sessions.show');
    Route::get('admin/sessions/edit/{sesion}', [SessionController::class, 'edit'])->name('admin.sessions.edit');
    Route::put('admin/sessions/{sesion}', [SessionController::class, 'update'])->name('admin.sessions.update');
    Route::delete('admin/sessions/{sesion}', [SessionController::class, 'destroy'])->name('admin.sessions.destroy');
    Route::post('admin/sessions/cargarpelis', [SessionController::class, 'getNomPelis'])->name('admin.sessions.cargarpelis');

    // BACKEND Sales
    Route::get('admin/sales', [SalesController::class, 'index'])->name('admin.sales');
    Route::get('admin/sales/create', [SalesController::class, 'create'])->name('admin.sales.create');
    Route::post('admin/sales', [SalesController::class, 'store'])->name('admin.sales.store');
    Route::get('admin/sales/{venta}', [SalesController::class, 'show'])->name('admin.sales.show');
    Route::get('admin/sales/edit/{venta}', [SalesController::class, 'edit'])->name('admin.sales.edit');
    Route::put('admin/sales/{venta}', [SalesController::class, 'update'])->name('admin.sales.update');
    Route::delete('admin/sales/{venta}', [SalesController::class, 'destroy'])->name('admin.sales.destroy');

    // BACKEND Ratings
    Route::get('admin/ratings', [RatingController::class, 'index'])->name('admin.ratings');
    Route::get('admin/ratings/create', [RatingController::class, 'create'])->name('admin.ratings.create');
    Route::post('admin/ratings', [RatingController::class, 'store'])->name('admin.ratings.store');
    Route::get('admin/ratings/{valoracion}', [RatingController::class, 'show'])->name('admin.ratings.show');
    Route::get('admin/ratings/edit/{valoracion}', [RatingController::class, 'edit'])->name('admin.ratings.edit');
    Route::put('admin/ratings/{valoracion}', [RatingController::class, 'update'])->name('admin.ratings.update');
    Route::delete('admin/ratings/{valoracion}', [RatingController::class, 'destroy'])->name('admin.ratings.destroy');

    // BACKEND Tickets
    Route::get('admin/tickets', [TicketController::class, 'index'])->name('admin.tickets');
    Route::get('admin/tickets/create', [TicketController::class, 'create'])->name('admin.tickets.create');
    Route::post('admin/tickets', [TicketController::class, 'store'])->name('admin.tickets.store');
    Route::get('admin/tickets/{entrada}', [TicketController::class, 'show'])->name('admin.tickets.show');
    Route::get('admin/tickets/edit/{entrada}', [TicketController::class, 'edit'])->name('admin.tickets.edit');
    Route::put('admin/tickets/{entrada}', [TicketController::class, 'update'])->name('admin.tickets.update');
    Route::delete('admin/tickets/{entrada}', [TicketController::class, 'destroy'])->name('admin.tickets.destroy');

    // BACKEND Prices
    Route::get('admin/prices', [PriceController::class, 'index'])->name('admin.prices');
    Route::get('admin/prices/create', [PriceController::class, 'create'])->name('admin.prices.create');
    Route::post('admin/prices', [PriceController::class, 'store'])->name('admin.prices.store');
    Route::get('admin/prices/{precio}', [PriceController::class, 'show'])->name('admin.prices.show');
    Route::get('admin/prices/edit/{precio}', [PriceController::class, 'edit'])->name('admin.prices.edit');
    Route::put('admin/prices/{precio}', [PriceController::class, 'update'])->name('admin.prices.update');
    Route::delete('admin/prices/{precio}', [PriceController::class, 'destroy'])->name('admin.prices.destroy');
});
