<?php

use App\Models\JubelioToken;

if (!function_exists('token')) {
    function token()
    {
        $token = JubelioToken::where('id',1)->first();
        $tokens = $token->token;
        return $tokens;
    }
}
