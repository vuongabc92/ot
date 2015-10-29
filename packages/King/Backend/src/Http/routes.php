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

    //User
    Route::get('/users', ['as' => 'backend_users', 'uses' => 'UserController@index']);
    Route::get('/users/{role_id}/by-role', ['as' => 'backend_users_by_role', 'uses' => 'UserController@usersByRole']);
    Route::get('/user/add', ['as' => 'backend_user_add', 'uses' => 'UserController@add']);
    Route::get('/user/{id}/edit', ['as' => 'backend_user_edit', 'uses' => 'UserController@edit']);
    Route::post('/user/save', ['as' => 'backend_user_save', 'uses' => 'UserController@save']);
    Route::get('/user/{id}/delete/{token}', ['as' => 'backend_user_delete', 'uses' => 'UserController@delete']);
    Route::get('/user/{id}/toggle-show-hide', ['as' => 'backend_user_active', 'uses' => 'UserController@toggleShowHide']);

    //Post Category
    Route::get('/post-categories', ['as' => 'backend_post_categories', 'uses' => 'PostCategoryController@index']);
    Route::get('/post-category/add', ['as' => 'backend_pc_add', 'uses' => 'PostCategoryController@add']);
    Route::get('/post-category/{id}/edit', ['as' => 'backend_pc_edit', 'uses' => 'PostCategoryController@edit']);
    Route::post('/post-category/save', ['as' => 'backend_pc_save', 'uses' => 'PostCategoryController@save']);
    Route::get('/post-category/{id}/delete/{token}', ['as' => 'backend_pc_delete', 'uses' => 'PostCategoryController@delete']);
    Route::get('/post-category/{id}/toggle-show-hide', ['as' => 'backend_pc_active', 'uses' => 'PostCategoryController@toggleShowHide']);

    //Post
    Route::get('/p/{slug}/all', ['as' => 'backend_posts', 'uses' => 'PostController@index']);
    Route::get('/p/{slug}/add', ['as' => 'backend_post_add', 'uses' => 'PostController@add']);
    Route::get('/p/{slug}/{id}/edit', ['as' => 'backend_post_edit', 'uses' => 'PostController@edit']);
    Route::get('/p/{slug}/{id}/delete/{token}', ['as' => 'backend_post_delete', 'uses' => 'PostController@delete']);
    Route::post('/p/{slug}/save', ['as' => 'backend_post_save', 'uses' => 'PostController@save']);
    Route::get('/p/{slug}/{id}/toggle-show-hide', ['as' => 'backend_post_active', 'uses' => 'PostController@toggleShowHide']);

    //Meta
    Route::get('/meta', ['as' => 'backend_meta', 'uses' => 'MetaController@index']);
    Route::get('/meta/add', ['as' => 'backend_meta_add', 'uses' => 'MetaController@add']);
    Route::get('/meta/{id}/edit', ['as' => 'backend_meta_edit', 'uses' => 'MetaController@edit']);
    Route::get('/meta/{id}/delete/{token}', ['as' => 'backend_meta_delete', 'uses' => 'MetaController@delete']);
    Route::post('/meta/save', ['as' => 'backend_meta_save', 'uses' => 'MetaController@save']);
    Route::get('/meta/{id}/toggle-show-hide', ['as' => 'backend_meta_active', 'uses' => 'MetaController@toggleShowHide']);

    //Image Category
    Route::get('/image-categories', ['as' => 'backend_image_categories', 'uses' => 'ImageCategoryController@index']);
    Route::get('/image-category/add', ['as' => 'backend_ic_add', 'uses' => 'ImageCategoryController@add']);
    Route::get('/image-category/{id}/edit', ['as' => 'backend_ic_edit', 'uses' => 'ImageCategoryController@edit']);
    Route::post('/image-category/save', ['as' => 'backend_ic_save', 'uses' => 'ImageCategoryController@save']);
    Route::get('/image-category/{id}/delete/{token}', ['as' => 'backend_ic_delete', 'uses' => 'ImageCategoryController@delete']);
    Route::get('/image-category/{id}/toggle-show-hide', ['as' => 'backend_ic_active', 'uses' => 'ImageCategoryController@toggleShowHide']);

    //Image
    Route::get('/i/{slug}/all', ['as' => 'backend_images', 'uses' => 'ImageController@index']);
    Route::get('/i/{slug}/add', ['as' => 'backend_image_add', 'uses' => 'ImageController@add']);
    Route::get('/i/{slug}/{id}/edit', ['as' => 'backend_image_edit', 'uses' => 'ImageController@edit']);
    Route::get('/i/{slug}/{id}/delete/{token}', ['as' => 'backend_image_delete', 'uses' => 'ImageController@delete']);
    Route::post('/i/{slug}/save', ['as' => 'backend_image_save', 'uses' => 'ImageController@save']);
    Route::get('/i/{slug}/{id}/toggle-show-hide', ['as' => 'backend_image_active', 'uses' => 'ImageController@toggleShowHide']);

    //Map
    Route::get('/map', ['as' => 'backend_map', 'uses' => 'MapController@index']);
    Route::post('/map/save', ['as' => 'backend_map_save', 'uses' => 'MapController@save']);

    //Category Root
    Route::get('/category-root', ['as' => 'backend_category_root', 'uses' => 'CategoryRootController@index']);
    Route::get('/category-root/add', ['as' => 'backend_cr_add', 'uses' => 'CategoryRootController@add']);
    Route::get('/category-root/{id}/edit', ['as' => 'backend_cr_edit', 'uses' => 'CategoryRootController@edit']);
    Route::post('/category-root/save', ['as' => 'backend_cr_save', 'uses' => 'CategoryRootController@save']);
    Route::get('/category-root/{id}/delete/{token}', ['as' => 'backend_cr_delete', 'uses' => 'CategoryRootController@delete']);
    Route::get('/category-root/{id}/toggle-show-hide', ['as' => 'backend_cr_active', 'uses' => 'CategoryRootController@toggleShowHide']);

    //Category One
    Route::get('/co/{slug}/all', ['as' => 'backend_category_one', 'uses' => 'CategoryOneController@index']);
    Route::get('/co/{slug}/add', ['as' => 'backend_co_add', 'uses' => 'CategoryOneController@add']);
    Route::get('/co/{slug}/{id}/edit', ['as' => 'backend_co_edit', 'uses' => 'CategoryOneController@edit']);
    Route::post('/co/{slug}/save', ['as' => 'backend_co_save', 'uses' => 'CategoryOneController@save']);
    Route::get('/co/{slug}/{id}/delete/{token}', ['as' => 'backend_co_delete', 'uses' => 'CategoryOneController@delete']);
    Route::get('/co/{slug}/{id}/toggle-show-hide', ['as' => 'backend_co_active', 'uses' => 'CategoryOneController@toggleShowHide']);

    //Category Two
    Route::get('/category-two', ['as' => 'backend_category_two', 'uses' => 'CategoryTwoController@index']);
    Route::get('/category-two/add', ['as' => 'backend_ct_add', 'uses' => 'CategoryTwoController@add']);
    Route::get('/category-two/{id}/edit', ['as' => 'backend_ct_edit', 'uses' => 'CategoryTwoController@edit']);
    Route::post('/category-two/save', ['as' => 'backend_ct_save', 'uses' => 'CategoryTwoController@save']);
    Route::get('/category-two/{id}/delete/{token}', ['as' => 'backend_ct_delete', 'uses' => 'CategoryTwoController@delete']);
    Route::get('/category-two/{id}/toggle-show-hide', ['as' => 'backend_ct_active', 'uses' => 'CategoryTwoController@toggleShowHide']);

    //Category Three
    Route::get('/category-three', ['as' => 'backend_category_three', 'uses' => 'CategoryThreeController@index']);
    Route::get('/category-three/add', ['as' => 'backend_cth_add', 'uses' => 'CategoryThreeController@add']);
    Route::get('/category-three/{id}/edit', ['as' => 'backend_cth_edit', 'uses' => 'CategoryThreeController@edit']);
    Route::post('/category-three/save', ['as' => 'backend_cth_save', 'uses' => 'CategoryThreeController@save']);
    Route::get('/category-three/{id}/delete/{token}', ['as' => 'backend_cth_delete', 'uses' => 'CategoryThreeController@delete']);
    Route::get('/category-three/{id}/toggle-show-hide', ['as' => 'backend_cth_active', 'uses' => 'CategoryThreeController@toggleShowHide']);

    //Product
    Route::get('/products', ['as' => 'backend_products', 'uses' => 'ProductController@index']);
    Route::get('/product/add', ['as' => 'backend_product_add', 'uses' => 'ProductController@add']);
    Route::get('/product/{id}/edit', ['as' => 'backend_product_edit', 'uses' => 'ProductController@edit']);
    Route::post('/product/save', ['as' => 'backend_product_save', 'uses' => 'ProductController@save']);
    Route::get('/product/{id}/delete/{token}', ['as' => 'backend_product_delete', 'uses' => 'ProductController@delete']);
    Route::get('/product/{id}/toggle-show-hide', ['as' => 'backend_product_active', 'uses' => 'ProductController@toggleShowHide']);
    Route::post('/product/delete-selected', ['as' => 'backend_product_delete_selected', 'uses' => 'ProductController@deleteSelected']);
});
