<?php

use App\Models\Sosmed;

if (!function_exists('waDua')) {
    function waDua()
    {
        $wa = Sosmed::where('name','Whatsapp 2')->first();
        $wa = $wa->value;
        return $wa;
    }
}
