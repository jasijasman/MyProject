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

Route::get('/a', function () {
    return view('a');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/lesson/create', 'LessonController@newLesson');

Route::get('/add', 'ManageFileController@attachFile')->name('add');
// Route::get('/viewFile', 'ManageFileController@getdata')->name('viewFile.getdata');

//returning to view file
Route::get('viewUploads', 'ViewFileController@viewFile')->name('viewUploads');


Route::get('viewFile', 'ViewFileController@index')->name('viewFile');
Route::get('document-list/{id}/edit', 'ViewFileController@edit');
Route::post('document-list/store', 'ViewFileController@store');
Route::get('viewFile/delete/{id}', 'ViewFileController@destroy');

Route::post('/upload', 'ManageFileController@uploadFile')->name('upload');
