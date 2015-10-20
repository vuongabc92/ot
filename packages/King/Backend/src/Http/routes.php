<?php

Route::match(['get', 'post'], 'auth/login', ['as' => 'backend_login', 'uses' => 'AuthController@login']);
Route::match(['get', 'post'], 'auth/logout', ['as' => 'backend_logout', 'uses' => 'AuthController@logout']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('/', ['as' => 'backend_dashboard', 'uses' => 'IndexController@index']);

    //Role
    Route::get('/roles', ['as' => 'backend_roles', 'uses' => 'RoleController@index']);
    Route::get('/role/add', ['as' => 'backend_role_add', 'uses' => 'RoleController@add']);
    Route::get('/role/{id}/edit', ['as' => 'backend_role_edit', 'uses' => 'RoleController@edit']);
    Route::get('/role/{id}/delete/{token}', ['as' => 'backend_role_delete', 'uses' => 'RoleController@delete']);
    Route::post('/role/save', ['as' => 'backend_role_save', 'uses' => 'RoleController@save']);
    Route::get('/role/{id}/toggle-show-hide', ['as' => 'backend_role_active', 'uses' => 'RoleController@toggleShowHide']);

    //Users
    Route::get('/users', ['as' => 'backend_users', 'uses' => 'UserController@index']);
    Route::get('/users/{role_id}/by-role', ['as' => 'backend_users_by_role', 'uses' => 'UserController@usersByRole']);
    Route::get('/user/add', ['as' => 'backend_user_add', 'uses' => 'UserController@add']);
    Route::get('/user/{id}/edit', ['as' => 'backend_user_edit', 'uses' => 'UserController@edit']);
    Route::post('/user/save', ['as' => 'backend_user_save', 'uses' => 'UserController@save']);
    Route::get('/user/{id}/delete/{token}', ['as' => 'backend_user_delete', 'uses' => 'UserController@delete']);
    Route::get('/user/{id}/toggle-show-hide', ['as' => 'backend_user_active', 'uses' => 'UserController@toggleShowHide']);

    //Post category
    Route::get('/post-categories', ['as' => 'backend_post_categories', 'uses' => 'PostCategoryController@index']);
    Route::get('/post-category/add', ['as' => 'backend_pc_add', 'uses' => 'PostCategoryController@add']);
    Route::get('/post-category/{id}/edit', ['as' => 'backend_pc_edit', 'uses' => 'PostCategoryController@edit']);
    Route::post('/post-category/save', ['as' => 'backend_pc_save', 'uses' => 'PostCategoryController@save']);
    Route::get('/post-category/{id}/delete/{token}', ['as' => 'backend_pc_delete', 'uses' => 'PostCategoryController@delete']);
    Route::get('/post-category/{id}/toggle-show-hide', ['as' => 'backend_pc_active', 'uses' => 'PostCategoryController@toggleShowHide']);


    //Route::get('/p/{slug}', ['as' => 'backend_posts', 'uses' => 'PostCategoryController@index']);
    Route::get('/p/{slug}/all', ['as' => 'backend_posts', 'uses' => 'PostController@index']);
    Route::get('/p/{slug}/add', ['as' => 'backend_post_add', 'uses' => 'PostController@add']);
    Route::get('/p/{slug}/{id}/edit', ['as' => 'backend_post_edit', 'uses' => 'PostController@edit']);
    Route::get('/p/{slug}/{id}/delete/{token}', ['as' => 'backend_post_delete', 'uses' => 'PostController@delete']);
    Route::post('/p/{slug}/save', ['as' => 'backend_post_save', 'uses' => 'PostController@save']);
    Route::get('/p/{slug}/{id}/toggle-show-hide', ['as' => 'backend_post_active', 'uses' => 'PostController@toggleShowHide']);
});
