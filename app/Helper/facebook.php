<?php

use App\Models\Sosmed;

if (!function_exists('fb')) {
    function fb()
    {
        $wa = Sosmed::where('name','Facebook')->first();
        $wa = $wa->value;
        return $wa;
    }
}
