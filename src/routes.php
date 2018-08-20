<?php

Route::group(['prefix' => '/admin/blog', 'middleware' => config('blog.admin_middleware')], function()
{
    Route::get('/', 'didcode\Blog\AdminController@index')->name('didcode-admin-blog');
    Route::get('/post/create', 'didcode\Blog\AdminController@createPost')->name('didcode-admin-create-post');
    Route::post('/post/create', 'didcode\Blog\AdminController@createPost')->name('didcode-admin-create-post');
    Route::get('/post/{post}/edit', 'didcode\Blog\AdminController@editPost')->name('didcode-admin-edit-post');
    Route::post('/post/{post}/edit', 'didcode\Blog\AdminController@editPost')->name('didcode-admin-edit-post');
    Route::get('/post/{post}/delete', 'didcode\Blog\AdminController@deletePost')->name('didcode-admin-delete-post');
    Route::get('/post/{post}/publish', 'didcode\Blog\AdminController@publishPost')->name('didcode-admin-post-publish');

    Route::get('/category/create', 'didcode\Blog\AdminController@createCategory')->name('didcode-admin-create-category');
    Route::post('/category/create', 'didcode\Blog\AdminController@createCategory')->name('didcode-admin-create-category');
    Route::get('/category/{category}/edit', 'didcode\Blog\AdminController@editCategory')->name('didcode-admin-edit-category');
    Route::post('/category/{category}/edit', 'didcode\Blog\AdminController@editCategory')->name('didcode-admin-edit-category');
    Route::get('/category/{category}/delete', 'didcode\Blog\AdminController@deleteCategory')->name('didcode-admin-delete-category');

    Route::post('/save_options', 'didcode\Blog\AdminController@ajax_options_save')->name('didcode-admin-ajax-options-save');
});

Route::get('/feed' , 'didcode\Blog\BlogController@rss')->name('didcode-feed');

Route::get(config('blog.base_path'), 'didcode\Blog\BlogController@index')->name('didcode-blog');
Route::get(config('blog.base_path').'/c-{slug}', 'didcode\Blog\BlogController@showCategory')->name('didcode-show-category');
Route::get(config('blog.base_path').'/{slug}', 'didcode\Blog\BlogController@showPost')->name('didcode-show-post');
