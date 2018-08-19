<?php

Route::group(['prefix' => '/admin'], function()
{
    Route::get('/blog', 'didcode\Blog\AdminController@index')->name('didcode-admin-blog');
    Route::get('/post/create', 'didcode\Blog\AdminController@createPost')->name('didcode-admin-create-post');
    Route::get('/post/{id}/edit', 'didcode\Blog\AdminController@editPost')->name('didcode-admin-edit-post');

    Route::post('/post/{id}/image', 'didcode\Blog\AdminController@addImage')->name('didcode-admin-add-image');
    Route::get('/post/{id}/image', 'didcode\Blog\AdminController@formAddImage')->name('didcode-admin-form-add-image');

    Route::post('/blog/save_post', 'didcode\Blog\AdminController@ajax_post_save')->name('didcode-admin-ajax-post-save');
    Route::post('/blog/load_post', 'didcode\Blog\AdminController@ajax_post_load')->name('didcode-admin-ajax-post-load');
    Route::post('/blog/publish_post', 'didcode\Blog\AdminController@ajax_post_publish')->name('didcode-admin-ajax-post-publish');

    Route::post('/blog/create_category', 'didcode\Blog\AdminController@ajax_category_create')->name('didcode-admin-ajax-category-create');

    Route::post('/blog/save_options', 'didcode\Blog\AdminController@ajax_options_save')->name('didcode-admin-ajax-options-save');

//    Route::resource('post', 'didcode\Blog\BlogPostController');
});

Route::get('/feed' , 'didcode\Blog\BlogController@rss')->name('didcode-feed');

Route::get(config('blog.base_path'), 'didcode\Blog\BlogController@index')->name('didcode-blog');
Route::get(config('blog.base_path').'/c-{slug}', 'didcode\Blog\BlogController@showCategory')->name('didcode-show-category');
Route::get(config('blog.base_path').'/{slug}', 'didcode\Blog\BlogController@showPost')->name('didcode-show-post');
