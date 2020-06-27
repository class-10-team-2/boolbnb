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
        Route::get('apartments/{apartment}/stats', 'ApartmentController@view_stats')->name('apartments.stats');
        Route::get('apartments/{apartment}/messages', 'ApartmentController@view_messages')->name('apartments.messages');
    });

Route::get('json-stats', 'User\ApartmentController@stats');

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
Route::post('/user/store_sponsoship', 'User\SponsorshipController@store_sponsorship')->middleware('auth');

// Pagina di ricerca
Route::get('search', 'Guest\SearchController@index')->name('guest.apartments.search');

// Ricevi json con risultati filtrati da Algolia
Route::get('/search/get-json-results', 'Guest\SearchController@search')->name('search.get.json.with.algolia.results');
Route::get('/search-sponsored', 'Guest\SearchController@searchSponsored')->name('search.sponsored');




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
