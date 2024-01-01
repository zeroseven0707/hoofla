<?php

use App\Models\Category;

if (!function_exists('category')) {
    function category()
    {
        $cat = Category::all();
        return $cat;
    }
}
