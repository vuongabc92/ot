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

    Route::get('/p/{slug}/all', ['as' => 'backend_posts', 'uses' => 'PostController@index']);
    Route::get('/p/{slug}/add', ['as' => 'backend_post_add', 'uses' => 'PostController@add']);
    Route::get('/p/{slug}/{id}/edit', ['as' => 'backend_post_edit', 'uses' => 'PostController@edit']);
    Route::get('/p/{slug}/{id}/delete/{token}', ['as' => 'backend_post_delete', 'uses' => 'PostController@delete']);
    Route::post('/p/{slug}/save', ['as' => 'backend_post_save', 'uses' => 'PostController@save']);
    Route::get('/p/{slug}/{id}/toggle-show-hide', ['as' => 'backend_post_active', 'uses' => 'PostController@toggleShowHide']);

    Route::get('/meta', ['as' => 'backend_meta', 'uses' => 'MetaController@index']);
    Route::get('/meta/add', ['as' => 'backend_meta_add', 'uses' => 'MetaController@add']);
    Route::get('/meta/{id}/edit', ['as' => 'backend_meta_edit', 'uses' => 'MetaController@edit']);
    Route::get('/meta/{id}/delete/{token}', ['as' => 'backend_meta_delete', 'uses' => 'MetaController@delete']);
    Route::post('/meta/save', ['as' => 'backend_meta_save', 'uses' => 'MetaController@save']);
    Route::get('/meta/{id}/toggle-show-hide', ['as' => 'backend_meta_active', 'uses' => 'MetaController@toggleShowHide']);

    //Post category
    Route::get('/image-categories', ['as' => 'backend_image_categories', 'uses' => 'ImageCategoryController@index']);
    Route::get('/image-category/add', ['as' => 'backend_ic_add', 'uses' => 'ImageCategoryController@add']);
    Route::get('/image-category/{id}/edit', ['as' => 'backend_ic_edit', 'uses' => 'ImageCategoryController@edit']);
    Route::post('/image-category/save', ['as' => 'backend_ic_save', 'uses' => 'ImageCategoryController@save']);
    Route::get('/image-category/{id}/delete/{token}', ['as' => 'backend_ic_delete', 'uses' => 'ImageCategoryController@delete']);
    Route::get('/image-category/{id}/toggle-show-hide', ['as' => 'backend_ic_active', 'uses' => 'ImageCategoryController@toggleShowHide']);

    Route::get('/i/{slug}/all', ['as' => 'backend_images', 'uses' => 'ImageController@index']);
    Route::get('/i/{slug}/add', ['as' => 'backend_image_add', 'uses' => 'ImageController@add']);
    Route::get('/i/{slug}/{id}/edit', ['as' => 'backend_image_edit', 'uses' => 'ImageController@edit']);
    Route::get('/i/{slug}/{id}/delete/{token}', ['as' => 'backend_image_delete', 'uses' => 'ImageController@delete']);
    Route::post('/i/{slug}/save', ['as' => 'backend_image_save', 'uses' => 'ImageController@save']);
    Route::get('/i/{slug}/{id}/toggle-show-hide', ['as' => 'backend_image_active', 'uses' => 'ImageController@toggleShowHide']);

    Route::get('/map', ['as' => 'backend_map', 'uses' => 'MapController@index']);

});
