<?php

use App\Models\Sosmed;

if (!function_exists('ig')) {
    function ig()
    {
        $wa = Sosmed::where('name','Instagram')->first();
        $wa = $wa->value;
        return $wa;
    }
}
