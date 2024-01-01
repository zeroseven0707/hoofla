<?php

namespace App\Http\Controllers;

use App\Models\GradeReseller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(){
        $data['grades'] = GradeReseller::all();
        return view('register-reseller',$data);
    }
}
