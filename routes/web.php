<?php

use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
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
    return view('welcome')->with(['pageSlug'=>'show']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\MatchController::class, 'menu'])->name('home');
Auth::routes();

Route::get('/home', [App\Http\Controllers\MatchController::class, 'menu'])->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

WebSocketsRouter::webSocket('/app/{appkey}/my-websocket', \App\MyCustomWebSocketHandler::class);

Route::get('/matches/menu', [App\Http\Controllers\MatchController::class, 'menu'])->name('match.menu');
Route::get('/matches/start', [App\Http\Controllers\MatchController::class, 'start'])->name('match.start');
Route::get('/matches/{id}', [App\Http\Controllers\MatchController::class, 'show'])->name('match.show');
Route::post('/matches/{id}/join', [App\Http\Controllers\MatchController::class, 'join'])->name('match.join');
Route::post('/store-move', [App\Http\Controllers\MatchController::class, 'storeMove'])->name('match.storeMove');
Route::get('/lobby', [App\Http\Controllers\MatchController::class, 'showLobbies'])->name('lobby.index');
Route::get('/check-game-status', [App\Http\Controllers\MatchController::class, 'checkGameStatus'])->name('match.check');
Route::post('/get-pgn/{matchId}', [App\Http\Controllers\MatchController::class, 'getPgn'])->name('match.pgn');
Route::post('/set-disconnection-time/{matchId}/{userColor}', [App\Http\Controllers\MatchController::class, 'setDisconnectionTime'])->name('match.setDisconnectionTime');
Route::post('/get-disconnection-time/{matchId}/{userColor}', [App\Http\Controllers\MatchController::class, 'getDisconnectionTime'])->name('match.getDisconnectionTime');
Route::post('/set-players-times', [App\Http\Controllers\MatchController::class, 'setPlayersTimes'])->name('match.setPlayersTimes');
Route::post('/get-players-times', [App\Http\Controllers\MatchController::class, 'getPlayersTimes'])->name('match.getPlayersTimes');
Route::post('/update-player-readiness', [App\Http\Controllers\MatchController::class, 'updateReadiness'])->name('match.updateReadiness');
Route::post('/check-players-ready', [App\Http\Controllers\MatchController::class, 'checkReadiness'])->name('match.checkReadiness');

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::get('/contacts/{contactId}', [App\Http\Controllers\ContactController::class, 'show'])->name('contact.show');
Route::delete('/contacts/{contactId}', [App\Http\Controllers\ContactController::class, 'destroy'])->name('contact.destroy');
Route::get('/contacts', [App\Http\Controllers\ContactController::class, 'getAllContacts'])->name('contact.getAllContacts');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::fallback(function () {
	return redirect()->route('home');
});
