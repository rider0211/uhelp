<?php
Route::group(['namespace' => 'Installer', 'prefix' => 'install', 'as' => 'SprukoAppInstaller::', 'middleware' => ['web','caninstall']], function() {
    
    Route::get('/', [ 'as' => 'welcome', 'uses' => 'WelcomeController@index']);
    Route::get('/requirement', [ 'as' => 'requirement', 'uses' => 'RequirementController@index']);
    Route::get('/permissions', [ 'as' => 'permissions', 'uses' => 'PermissionsController@index']);
    Route::get('/environment', [ 'as' => 'environment', 'uses' => 'EnvironmentController@index']);
    Route::post('environment/saveWizard', [ 'as' => 'environmentSaveWizard', 'uses' => 'EnvironmentController@installapp']);
    Route::get('database', ['as' => 'database',  'uses' => 'DatabaseController@index']);
    Route::get('register', ['as' => 'register',  'uses' => 'FinalController@logindetails']);
    Route::post('register', ['as' => 'registerstore',  'uses' => 'FinalController@logindetailsstore']);
    Route::get('final', ['as' => 'final', 'uses' => 'FinalController@index']);
  });
  
  Route::group(['namespace' => 'Installer', 'prefix' => 'update', 'middleware' => 'web', 'as' => 'SprukoUpdater::'], function(){
   
    Route::group(['middleware' => 'canupdate'],function(){
  
      Route::get('/', [ 'as' => 'welcome', 'uses' => 'UpdateController@index']);
  
      Route::get('overview', ['as' => 'overview','uses' => 'UpdateController@overview']);
  
      Route::get('database', ['as' => 'database', 'uses' => 'UpdateController@database']);
  
  
  
    });
  
     // This needs to be out of the middleware because right after the migration has been
      // run, the middleware sends a 404.
      Route::get('final', ['as' => 'final', 'uses' => 'UpdateController@finish']);
  
  });