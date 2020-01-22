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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/usuarios','UsuariosController@index')->name('usuarios');
Route::get('/formulario/registrar','UsuariosController@showLoginForm')->name('formulario-usuarios');
Route::post('/registrar/usuario','UsuariosController@StoreUser')->name('registrar-usuario');
Route::put('/actualizar/usuario','UsuariosController@updateUser');
Route::delete('eliminar/usuario/{id}','UsuariosController@DeleteUser')->name('eliminar-usuario');

Auth::routes();

/**
 * ================= PROVIDERS =====================
 */

Route::get('/proveedores','ProviderController@index');
Route::post('/registrar/proveedor','ProviderController@StoreProvider');
Route::put('/actualizar/proveedor','ProviderController@UpdateProvider');
Route::delete('/eliminar/proveedor/{id}','ProviderController@DeleteProvider');

/*
 * ============== CATEGORIES ==============
 */
Route::get('/categorias','CategoryController@index');
Route::post('/categorias/agregar','CategoryController@StoreCategory');
Route::delete('/categorias/eliminar/{id}','CategoryController@DeleteCategory');
Route::put('/categorias/actualizar','CategoryController@UpdateCategory');

/*
 * ============== BRANDS ==============
 */

Route::get('/marcas','BrandController@index');
Route::post('/marcas/agregar','BrandController@Store');
Route::put('/marcas/editar','BrandController@Update');
Route::delete('/marcas/eliminar/{id}','BrandController@Delete');

/*
 * ============== PRODUCTS ==============
 */

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
