<?php

Route::group(['prefix' => 'admin'], function()
{
    Route::get('blog', 'didcode\Blog\AdminController@index');
    Route::get('post/create', 'didcode\Blog\AdminController@createPost');
    Route::get('post/{id}/edit', 'didcode\Blog\AdminController@editPost');

    Route::post('post/{id}/image', 'didcode\Blog\AdminController@addImage');
    Route::get('post/{id}/image', 'didcode\Blog\AdminController@formAddImage');

    Route::post('blog/save_post', 'didcode\Blog\AdminController@ajax_post_save');
    Route::post('blog/load_post', 'didcode\Blog\AdminController@ajax_post_load');
    Route::post('blog/publish_post', 'didcode\Blog\AdminController@ajax_post_publish');

    Route::post('blog/create_category', 'didcode\Blog\AdminController@ajax_category_create');

    Route::post('blog/save_options', 'didcode\Blog\AdminController@ajax_options_save');

//    Route::resource('post', 'didcode\Blog\BlogPostController');
});

Route::get('feed' , 'didcode\Blog\BlogController@rss');

Route::get('blog' , 'didcode\Blog\BlogController@index');
Route::get('blog/c-{slug}', 'didcode\Blog\BlogController@showCategory');
Route::get('blog/{slug}', 'didcode\Blog\BlogController@showPost');
