<?php

use App\Models\Sosmed;

if (!function_exists('tiktok')) {
    function tiktok()
    {
        $wa = Sosmed::where('name','Tiktok')->first();
        $wa = $wa->value;
        return $wa;
    }
}
