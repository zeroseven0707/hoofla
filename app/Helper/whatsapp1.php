<?php

use App\Models\Sosmed;

if (!function_exists('waSatu')) {
    function waSatu()
    {
        $wa = Sosmed::where('name','Whatsapp 1')->first();
        $wa = $wa->value;
        return $wa;
    }
}
