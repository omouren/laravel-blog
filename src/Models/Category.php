<?php namespace didcode\Blog\Models;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Category extends Eloquent {
    protected $table = 'didcode_blog_categories';
    protected $fillable = ['name', 'slug'];

    function getUrlAttribute() {
        return '/blog/c-'.$this->slug.'/';
    }
}
