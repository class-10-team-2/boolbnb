<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('guest.index');
// })->name('guest.index');

Route::get('/', 'Guest\IndexController@index')->name('guest.index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::namespace('User')
    ->name('user.')
    ->prefix('user')
    ->middleware('auth')
    ->group(function () {
        Route::resource('apartments', 'ApartmentController');
        Route::get('apartments/{apartment}/stats', 'ApartmentController@stats')->name('apartments.stats');
    });

Route::namespace('Guest')
    ->name('guest.')
    ->prefix('guest')
    ->group(function () {
        Route::resource('apartments', 'ApartmentController');
        // Route::post('apartments/{apartment}', 'ApartmentController@message');
    });


// Route::post('/search', 'Guest\SearchController@index')->name('guest.search');
// Route::get('/search', 'Guest\SearchController@index')->name('guest.search'); // ???

// Braintree
Route::get('/payment/make', 'PaymentsController@make')->name('payment.make');
Route::namespace('User')
    ->prefix('user')
    ->middleware('auth')
    ->group(function () {
        Route::post('store_sponsoship', 'ApartmentController@store_sponsorship')->name('user.apartments.store_sponsoship');
        // Route::get('store_sponsoship', 'ApartmentController@view_sponsorship');
    });

// Pagina di ricerca
Route::get('guest/apartments/search', 'Guest\SearchController@index')->name('guest.apartments.search');

// Invio dati dal form di ricerca della index e restituisco un json
// Route::post('/search/get-json-with-input-values-from-index', 'Guest\SearchController@fromIndexToSearch')->name('search.get.json.from.index');

// Ricevi json con risultati filtrati da Algolia
Route::get('/search/get-json-with-algolia-results', 'Guest\SearchController@search')->name('search.get.json.with.algolia.results');




// Algolia
// Route::get('search', function() {
//
//     $query = ''; // <-- Change the query for testing.
//
//     $apartments = App\Apartment::search($query)
//                                 // ->where('rooms', '>=', 9)
//                                 ->get();
//
//     return $apartments;
// })->name('search');
