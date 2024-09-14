<?php

use Illuminate\Support\Facades\Route;

/*
|----------------------------- ---------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
      


        Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
            // Author
            // pattern means url
         Route::get('author/statusActive', 'AuthorController@status_active')->name('author.active.status');
         Route::get('author/statusDeactive', 'AuthorController@status_deactive')->name('author.deactive.status');
          Route::get('author/deleteAll', 'AuthorController@delete_all')->name('author.delete.all');
        Route::put('author/{id}/status', 'AuthorController@status');
        Route::resource('author', 'AuthorController');
         
         // Category
         Route::get('category/statusActive', 'CategoryController@status_active')->name('category.active.status');
         Route::get('category/statusDeactive', 'CategoryController@status_deactive')->name('category.deactive.status');
         Route::get('category/deleteAll', 'CategoryController@delete_all')->name('category.delete.all');
         Route::put('category/{id}/status', 'CategoryController@status');          
         Route::resource('category', 'CategoryController');

         // Book
          Route::get('book/statusActive', 'BookController@status_active')->name('book.active.status');
         Route::get('book/statusDeactive', 'BookController@status_deactive')->name('book.deactive.status');
         Route::get('book/deleteAll', 'BookController@delete_all')->name('book.delete.all');
         Route::put('book/{id}/status', 'BookController@status');
         Route::resource('book', 'BookController');
         
         // Media
          Route::get('media/statusActive', 'MediaController@status_active')->name('media.active.status');
         Route::get('media/statusDeactive', 'MediaController@status_deactive')->name('media.deactive.status');
         Route::get('media/deleteAll', 'MediaController@delete_all')->name('media.delete.all');
         Route::put('media/{id}/status', 'MediaController@status');
         Route::resource('media', 'MediaController');
         
         // Team
          Route::get('team/statusActive', 'TeamController@status_active')->name('team.active.status');
         Route::get('team/statusDeactive', 'TeamController@status_deactive')->name('team.deactive.status');
         Route::get('team/deleteAll', 'TeamController@delete_all')->name('team.delete.all');
         Route::put('team/{id}/status', 'TeamController@status');
         Route::resource('team', 'TeamController');
         // User
         Route::get('/profile', 'HomeController@profile');
         // no need to make a get route for change password because the page is same as in above route for change password as well
         Route::put('/profile/update','HomeController@profile_update')->name('profile.update');
         
         Route::post('/updatepassword', 'HomeController@updatepassword')->name('update.password');



        
 

});
Route::get('/', 'MainController@index');
Route::get('/about', 'MainController@about');
Route::get('/gallery', 'MainController@gallery');
Route::get('/contact', 'MainController@contact');
Route::get('/author', 'MainController@author');
//Route::resource('/admin/author', 'admin\AuthorController');
// Route::get('/', function() {
//     return view('welcome');
// });

Route::get('/category/{slug}', 'CategoryController@show')->name('category.show');
Route::get('/book/{slug}', 'BookController@show')->name('book.show');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
