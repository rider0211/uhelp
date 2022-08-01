<?php

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
use Spatie\Honeypot\ProtectAgainstSpam;

Route::prefix('uhelpupdate')->group(function() {
    Route::get('/', 'UhelpupdateController@index');
});

Route::middleware(ProtectAgainstSpam::class)->group(function() {

	Route::middleware(['checkinstallation'])->group(function () {

        
		Route::middleware(['admincountryblock','throttle:refresh', 'ipblockunblock', 'apichecking'])->group(function () {
            Route::group([ 'prefix'	 => 'admin'], function () {
                Route::get('envatoapitoken', 'EnvatoApiTokenController@index')->name('admin.envatoapitoken');
                Route::post('envatoapitoken', 'EnvatoApiTokenController@storeupdate')->name('admin.envatoapitoken.storeupdate');
                Route::get('envatolicensesearch', 'EnvatoApiTokenController@licensesearch')->name('admin.envatolicensesearch');
                Route::post('envatolicensesearch', 'EnvatoApiTokenController@licensesearchget')->name('admin.envatolicensesearchget');
                Route::post('ticketlicenseverify', 'EnvatoApiTokenController@ticketlicenseverify')->name('admin.ticketlicenseverify');
                Route::get('/cannedmessages', 'CannedmessagesController@index')->name('admin.cannedmessages');
                Route::get('/cannedmessages/create', 'CannedmessagesController@create')->name('admin.cannedmessages.create');
                Route::post('/cannedmessages/create', 'CannedmessagesController@store')->name('admin.cannedmessages.store');
                Route::get('/cannedmessages/edit/{id}', 'CannedmessagesController@edit')->name('admin.cannedmessages.edit');
                Route::post('/cannedmessages/update/{id}', 'CannedmessagesController@update')->name('admin.cannedmessages.update');
                Route::post('/cannedmessages/status/{id}', 'CannedmessagesController@status')->name('admin.cannedmessages.statuschange');
                Route::post('/cannedmessages/delete/{id}', 'CannedmessagesController@destroy')->name('admin.cannedmessages.delete');
                Route::post('/cannedmessages/delete', 'CannedmessagesController@destroyall')->name('admin.cannedmessages.deleteall');
            });

        });
        Route::group(['prefix' => 'admin'], function(){
            Route::get('licenseinfo', 'EnvatoAppinfoController@index')->name('admin.licenseinfo');
            Route::post('licenseinfoenter', 'EnvatoAppinfoController@store')->name('admin.licenseinfoenter');
            Route::post('licenseinfo/{id}', 'EnvatoAppinfoController@envatogetdetails')->name('admin.envatogetdetails');
        });
    });
});
