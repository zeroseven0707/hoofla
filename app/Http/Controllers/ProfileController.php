<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Bank;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $http = new \GuzzleHttp\Client;
        $prov = $http->get('https://api.rajaongkir.com/starter/province',[
            'headers' => [
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ]
        ]);
        $prov = json_decode((string)$prov->getBody(), true);
        $prov = $prov['rajaongkir']['results'];

        $http = new \GuzzleHttp\Client;
        $city = $http->get('https://pro.rajaongkir.com/api/city',[
            'query'=>[
                'province'=>auth()->user()->code_province
            ],
            'headers' => [
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ]
        ]);
        $city = json_decode((string)$city->getBody(), true);
        $city = $city['rajaongkir']['results'];

        $http = new \GuzzleHttp\Client;
        $sub = $http->get('https://pro.rajaongkir.com/api/subdistrict',[
            'query'=>[
                'city'=>auth()->user()->code_city
            ],
            'headers' => [
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ]
        ]);
        $sub = json_decode((string)$sub->getBody(), true);
        $sub = $sub['rajaongkir']['results'];

        $bank = Bank::all();
        return view('profile.edit', [
            'user' => $request->user(),
            'prov' => $prov,
            'city' => $city,
            'subdistrict' => $sub,
            'bank' => $bank
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['string', 'max:255'],
            'last_name' => ['string', 'max:255'],
            'address' => ['required', 'string'],
            'nomor_rekening' => ['required'],
            'account_holders_name' => ['required', 'string'],
            'no_wa' => ['required'],
            'province_code' => ['required'],
            'city_code' => ['required'],
            'subdistrict_code' => ['required'],
            'bank_id' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255']
        ]);

        $http = new \GuzzleHttp\Client();
        // Membaca data dari request
        $requestData = $request->all();
        $response = $http->get('https://pro.rajaongkir.com/api/subdistrict',[
            'query'=> [
                'city'=>$request['city_code']
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
        $jubelio = $http->post('https://api2.jubelio.com/contacts/',[
            'json'=> [
                'contact_id' => auth()->user()->contact_id,
                "contact_name"=> $request->first_name." ".$request->last_name,
                "contact_type"=> 0,
                "primary_contact"=> $request->first_name,
                "email"=> $request->email,
                "phone"=> $request->no_wa,
                "mobile"=> $request->no_wa,
                "fax"=> "null",
                "npwp"=> "null",
                "payment_term"=> -1,
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
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . token(),
                'Accept'        => 'application/json',
            ],
        ]);

        // dd($jube['contact_id']);
        $user = User::where('contact_id',auth()->user()->contact_id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address' => $request->address,
            'no_wa' => $request->no_wa,
            'province' => $shipping['province'],
            'city' => $shipping['city'],
            'subdistrict' => $shipping['subdistrict'],
            'code_province' => $request->province_code,
            'code_city' => $request->city_code,
            'code_subdistrict' => $request->subdistrict_code,
            'bank_id' => $request->bank_id,
            'nomor_rekening' => $request->nomor_rekening,
            'account_holders_name' => $request->account_holders_name,
        ]);


        return Redirect::route('profile.edit')->with('success', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
