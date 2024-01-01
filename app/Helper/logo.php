<?php

use App\Models\Logo;

if (!function_exists('logo')) {
    function logo()
    {
        $logo = Logo::where('status','active')->first();
        $logos = $logo->image;
        return $logos;
    }
}
