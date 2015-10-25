<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');

// 暗黙的なコントローラ

Route::controllers([
  'auth'     => 'Auth\AuthController',
  'password' => 'Auth\PasswordController',
  'attends'  => 'AttendsController',
  'events'   => 'EventsController',
]);

//Route::controller('attends', 'AttendsController');

// Resourceful

Route::resources([
  'users'        => 'UsersController',
  'reports'      => 'ReportsController',
  'groups'       => 'GroupsController',
  'user2group'   => 'User2GroupController',
  'pastereports' => 'PasteReportsController',
  'mevents'      => 'ManageEventsController',

]);

Route::resource('informations', 'InformationsController', ['only' => ['create', 'store']]);
