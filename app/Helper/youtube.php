<?php

use App\Models\Sosmed;

if (!function_exists('youtube')) {
    function youtube()
    {
        $wa = Sosmed::where('name','Youtube')->first();
        $wa = $wa->value;
        return $wa;
    }
}
