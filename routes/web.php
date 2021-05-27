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
Route::get('/', 'HomeController@index')->name('home');
Route::get('/categories', 'CategoryController@index')
->name('categories');
Route::get('/categories/{id}', 'CategoryController@detail')->name('categories-detail');
Route::get('/details/{id}', 'DetailController@index')->name('detail');
//Route::post('/details/{id}', 'DetailController@add')->name('detail-add');
Route::get('/register/success', 'Auth\RegisterController@success')->name('register-success');

Route::group(['middleware'=>['auth']], function(){ //dilakukan grouping sesuai dengan user yang sudah authentikasi/login
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/dashboard/products', 'DashboardProductController@index')
                ->name('dashboard-product');
        Route::get('/dashboard/products/create', 'DashboardProductController@create')
                ->name('dashboard-product-create');
        Route::post('/dashboard/products', 'DashboardProductController@store')
                ->name('dashboard-product-store');
        Route::get('/dashboard/products/{id}', 'DashboardProductController@details')
                ->name('dashboard-product-details');
        Route::post('/dashboard/products/{id}', 'DashboardProductController@update')
                ->name('dashboard-product-update');
                
        Route::post('/dashboard/products/gallery/upload', 'DashboardProductController@uploadGallery')
                ->name('dashboard-product-gallery-upload');
        Route::get('/dashboard/products/gallery/delete/{id}', 'DashboardProductController@deleteGallery')
                ->name('dashboard-product-gallery-delete');

        Route::get('/dashboard/settings', 'DashboardSettingController@store')
                ->name('dashboard-settings-store');
        Route::get('/dashboard/account', 'DashboardSettingController@account')
                ->name('dashboard-settings-account');
        Route::post('/dashboard/account/{redirect}', 'DashboardSettingController@update')
                ->name('dashboard-settings-redirect');
});

Route::prefix('admin') //Mengelompokkan route halaman admin menggunakan prefix agar tidak perlu menulis ulang admin/, nantinya Hanya admin yg bisa masuk
        ->namespace('Admin')
        ->middleware(['auth','admin']) //auth untuk memverifikasi bahwa user telah login dan yg login merupakan user admin
        ->group(function() {
                Route::get('/','DashboardController@index')->name('admin-dashboard');
                //resource, otomatis pada controller yang terdapat pada folder admin sudah berisi fungsi crud
                Route::resource('category','CategoryController');
                Route::resource('user','UserController');
                Route::resource('product','ProductController');
                Route::resource('product-gallery','ProductGalleryController');
        });

Auth::routes();

