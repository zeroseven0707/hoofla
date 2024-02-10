<?php

use App\Models\Sosmed;

if (!function_exists('shopee')) {
    function shopee()
    {
        $wa = Sosmed::where('name','Shopee')->first();
        $wa = $wa->value;
        return $wa;
    }
}
