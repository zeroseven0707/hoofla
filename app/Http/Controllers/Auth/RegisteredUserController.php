<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\GradeReseller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $http = new \GuzzleHttp\Client;
        $prov = $http->get('https://api.rajaongkir.com/starter/province',[
            'headers' => [
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ]
        ]);
        $prov = json_decode((string)$prov->getBody(), true);
        $data['prov'] = $prov['rajaongkir']['results'];
        $data['bank'] = Bank::all();
        $data['grades'] = GradeReseller::all();
        return view('auth.register',$data);
    }
    public function Agen(): View
    {
        $http = new \GuzzleHttp\Client;
        $prov = $http->get('https://api.rajaongkir.com/starter/province',[
            'headers' => [
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ]
        ]);
        $prov = json_decode((string)$prov->getBody(), true);
        $data['prov'] = $prov['rajaongkir']['results'];
        $data['bank'] = Bank::all();
        $data['grades'] = GradeReseller::all();
        return view('auth.agen',$data);
    }
    public function distributor(): View
    {
        $http = new \GuzzleHttp\Client;
        $prov = $http->get('https://api.rajaongkir.com/starter/province',[
            'headers' => [
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ]
        ]);
        $prov = json_decode((string)$prov->getBody(), true);
        $data['prov'] = $prov['rajaongkir']['results'];
        $data['bank'] = Bank::all();
        $data['grades'] = GradeReseller::all();
        return view('auth.distributor',$data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'nomor_rekening' => ['required'],
            'account_holders_name' => ['required', 'string'],
            'no_ktp' => ['required'],
            'no_wa' => ['required'],
            'foto_ktp' => ['required'],
            'province_code' => ['required'],
            'city_code' => ['required'],
            'subdistrict_code' => ['required'],
            'bank_id' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required'],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $http = new \GuzzleHttp\Client();
        // Membaca data dari request
        $requestData = $request->all();
        $response = $http->get('https://pro.rajaongkir.com/api/subdistrict',[
            'query'=> [
                'city'=>$requestData['city_code']
            ],
            'headers' => [
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ]
        ]);
        $json = json_decode((string)$response->getBody(), true);
        $subdistrict = $json['rajaongkir']['results'];
        $filter = collect($subdistrict)->where('subdistrict_id', '=', $requestData['subdistrict_code']);
        $shipping = [];
        foreach ($filter as $value) {
            $shipping =[
                'province_code' => $value['province_id'],
                'city_code' => $value['city_id'],
                'subdistrict_code' => $value['subdistrict_id'],
                'city' => $value['city'],
                'province' => $value['province'],
                'subdistrict' => $value['subdistrict_name']
            ];
        }
        if($request->roles == 1){
            $level = "distributor";
            $note = "DISTRIBUTOR-WEBSTORE";
        }elseif($request->roles == 2){
            $level = "agen";
            $note = "AGEN-WEBSTORE";
        }elseif($request->roles == 3){
            $level = "sub agen";
            $note = "SUB AGEN-WEBSTORE";
        }
        elseif($request->roles == 4){
            $level = "reseller";
            $note = "RESELLER-WEBSTORE";
        }
        $jubelio = $http->post('https://api2.jubelio.com/contacts/',[
            'json'=> [
                "contact_name"=> $request->first_name." ".$request->last_name,
                "contact_type"=> 0,
                "primary_contact"=> $request->first_name,
                "contact_position"=> "RESELLER",
                "email"=> $request->email,
                "phone"=> $request->no_wa,
                "mobile"=> $request->no_wa,
                "fax"=> "null",
                "npwp"=> "null",
                "payment_term"=> -1,
                "notes"=> $note,
                "s_address"=> $request->address,
                "s_area"=> "null",
                "s_city"=>  $shipping['city'],
                "s_province"=>  $shipping['province'],
                "s_post_code"=> "46462",
                "b_address"=> $request->address,
                "b_area"=> "null",
                "b_city"=>  $shipping['city'],
                "b_province"=> $shipping['province'],
                "b_post_code"=> "46462",
                "is_dropshipper"=> false,
                "is_reseller"=> false,
                "category_id"=> $request->roles,
                "nik"=> $request->no_ktp
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . token(),
                'Accept'        => 'application/json',
            ],
        ]);
        $jube = json_decode((string)$jubelio->getBody(), true);

        // dd($jube['contact_id']);
        $user = User::create([
            'contact_id' => $jube['contact_id'],
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'no_ktp' => $request->no_ktp,
            'no_wa' => $request->no_wa,
            'foto_ktp' => $request->file('foto_ktp')->store('ktp'),
            'province' => $shipping['province'],
            'city' => $shipping['city'],
            'subdistrict' => $shipping['subdistrict'],
            'code_province' => $request->province_code,
            'code_city' => $request->city_code,
            'code_subdistrict' => $request->subdistrict_code,
            'bank_id' => $request->bank_id,
            'nomor_rekening' => $request->nomor_rekening,
            'account_holders_name' => $request->account_holders_name,
            'level' => $level
        ]);


        event(new Registered($user));

        Auth::login($user);
        if ($user->level == 'admin') {
            # code...
            return redirect(RouteServiceProvider::HOME);
        }else{
            return redirect('/');
        }
    }

    public function distributor_store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'nomor_rekening' => ['required'],
            'account_holders_name' => ['required', 'string'],
            'no_ktp' => ['required'],
            'no_wa' => ['required'],
            'foto_ktp' => ['required'],
            'province_code' => ['required'],
            'city_code' => ['required'],
            'subdistrict_code' => ['required'],
            'bank_id' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required'],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $http = new \GuzzleHttp\Client();
        // Membaca data dari request
        $requestData = $request->all();
        $response = $http->get('https://pro.rajaongkir.com/api/subdistrict',[
            'query'=> [
                'city'=>$requestData['city_code']
            ],
            'headers' => [
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ]
        ]);
        $json = json_decode((string)$response->getBody(), true);
        $subdistrict = $json['rajaongkir']['results'];
        $filter = collect($subdistrict)->where('subdistrict_id', '=', $requestData['subdistrict_code']);
        $shipping = [];
        foreach ($filter as $value) {
            $shipping =[
                'province_code' => $value['province_id'],
                'city_code' => $value['city_id'],
                'subdistrict_code' => $value['subdistrict_id'],
                'city' => $value['city'],
                'province' => $value['province'],
                'subdistrict' => $value['subdistrict_name']
            ];
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'no_ktp' => $request->no_ktp,
            'no_wa' => $request->no_wa,
            'foto_ktp' => $request->file('foto_ktp')->store('ktp'),
            'province' => $shipping['province'],
            'city' => $shipping['city'],
            'subdistrict' => $shipping['subdistrict'],
            'code_province' => $request->province_code,
            'code_city' => $request->city_code,
            'code_subdistrict' => $request->subdistrict_code,
            'bank_id' => $request->bank_id,
            'nomor_rekening' => $request->nomor_rekening,
            'account_holders_name' => $request->account_holders_name,
            'level' => 'distributor'
        ]);

        event(new Registered($user));

        Auth::login($user);
        if ($user->level == 'admin') {
            # code...
            return redirect(RouteServiceProvider::HOME);
        }else{
            return redirect('/');
        }
    }
    public function agen_store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'nomor_rekening' => ['required'],
            'account_holders_name' => ['required', 'string'],
            'no_ktp' => ['required'],
            'no_wa' => ['required'],
            'foto_ktp' => ['required'],
            'province_code' => ['required'],
            'city_code' => ['required'],
            'subdistrict_code' => ['required'],
            'bank_id' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required'],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $http = new \GuzzleHttp\Client();
        // Membaca data dari request
        $requestData = $request->all();
        $response = $http->get('https://pro.rajaongkir.com/api/subdistrict',[
            'query'=> [
                'city'=>$requestData['city_code']
            ],
            'headers' => [
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ]
        ]);
        $json = json_decode((string)$response->getBody(), true);
        $subdistrict = $json['rajaongkir']['results'];
        $filter = collect($subdistrict)->where('subdistrict_id', '=', $requestData['subdistrict_code']);
        $shipping = [];
        foreach ($filter as $value) {
            $shipping =[
                'province_code' => $value['province_id'],
                'city_code' => $value['city_id'],
                'subdistrict_code' => $value['subdistrict_id'],
                'city' => $value['city'],
                'province' => $value['province'],
                'subdistrict' => $value['subdistrict_name']
            ];
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'no_ktp' => $request->no_ktp,
            'no_wa' => $request->no_wa,
            'foto_ktp' => $request->file('foto_ktp')->store('ktp'),
            'province' => $shipping['province'],
            'city' => $shipping['city'],
            'subdistrict' => $shipping['subdistrict'],
            'code_province' => $request->province_code,
            'code_city' => $request->city_code,
            'code_subdistrict' => $request->subdistrict_code,
            'bank_id' => $request->bank_id,
            'nomor_rekening' => $request->nomor_rekening,
            'account_holders_name' => $request->account_holders_name,
            'level' => 'agen'
        ]);

        event(new Registered($user));

        Auth::login($user);
        if ($user->level == 'admin') {
            # code...
            return redirect(RouteServiceProvider::HOME);
        }else{
            return redirect('/');
        }
    }
}
