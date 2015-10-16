<?php

Route::match(['get', 'post'], 'auth/login', ['as' => 'backend_login', 'uses' => 'AuthController@login']);
Route::match(['get', 'post'], 'auth/logout', ['as' => 'backend_logout', 'uses' => 'AuthController@logout']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('/', ['as' => 'backend_dashboard', 'uses' => 'IndexController@index']);

    Route::get('/roles', ['as' => 'backend_roles', 'uses' => 'RoleController@index']);
    Route::get('/role/add', ['as' => 'backend_role_add', 'uses' => 'RoleController@add']);
    Route::get('/role/{id}/edit', ['as' => 'backend_role_edit', 'uses' => 'RoleController@edit']);
    Route::get('/role/{id}/delete/{token}', ['as' => 'backend_role_delete', 'uses' => 'RoleController@delete']);
    Route::post('/role/save', ['as' => 'backend_role_save', 'uses' => 'RoleController@save']);
});
