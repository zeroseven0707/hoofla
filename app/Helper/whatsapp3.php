<?php

use App\Models\Sosmed;

if (!function_exists('waTiga')) {
    function waTiga()
    {
        $wa = Sosmed::where('name','Whatsapp 3')->first();
        $wa = $wa->value;
        return $wa;
    }
}
