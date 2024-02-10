<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Comission;
use App\Models\DetailTransaction;
use App\Models\Faq;
use App\Models\GradeReseller;
use App\Models\Kupon;
use App\Models\PaymentReseller;
use App\Models\Pelanggan;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Variations;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Size;

class HomeController extends Controller
{
public function reseller_checkout(){
    return view('customer.checkout-reseller');
}
public function bundle(){

    $baseUrl = config('app.api_base_url');
    $apiToken = token();

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiToken,
        'Accept' => 'application/json',
    ])->get($baseUrl . '/inventory/item-bundles/');
    $product = $response->json();
    $data['product'] = $product['data'];
    dd($data['product']);
    return view('products',$data);
}
public function products(){
    return view('dashboard');
}
public function category(){
    $data['category'] = Category::all();
    return view('category',$data);
}
public function category_post(Request $request){
    try {
        $this->validate($request, [
            'name' => 'required',
            'sub_categories' => 'required',
        ]);

        $subCategories = explode(',', $request->input('sub_categories'));
        $sub = [];

        foreach ($subCategories as $key => $value) {
            $sub[] = $value;
        }

        // dd($sub);

        Category::create([
            'name' => $request->name,
            'sub' => $sub,
        ]);

        return back()->with('success', 'Successfully added category');
    } catch (ValidationException $e) {
        // Handle validation errors
        return back()->withErrors($e->validator->errors())->withInput();
    } catch (\Exception $e) {
        // Handle other exceptions
        return back()->with('error', 'An error occurred during category creation: ' . $e->getMessage());
    }
}
public function category_delete($id)
{
    Category::where('id',$id)->delete();
    return back()->with('success','successfully deleted category');
}
////////////////////////////////////////////////////////////////////////////////
public function home()
{
    return view('customer.home');
}

public function cart()
{
    // dd(session('cart'));
    return view('customer.cart');
}

public function checkout()
{
try {
    $session = session('cart');
    $http = new \GuzzleHttp\Client;
    $prov = $http->get('https://api.rajaongkir.com/starter/province', [
        'headers' => [
            'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
        ]
    ]);

    $prov = json_decode((string) $prov->getBody(), true);
    $data['prov'] = $prov['rajaongkir']['results'];

    $http = new \GuzzleHttp\Client;
    $berat = 0;
    $session = session()->get('cart');

    foreach ($session as $value) {
        $berat += $value['package_weight'];
    }

    $cost = Http::withHeaders([
        'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
        ])->post('https://pro.rajaongkir.com/api/cost', [
        'origin' => 23,
        'originType' => 'city',
        'destination' => Auth::user()->code_city,
        'destinationType' => 'subdistrict',
        'weight' => $berat,
        'courier' => 'jne'
    ]);

    if (!isset($cost['rajaongkir']['results'])) {
        throw new \Exception('Error fetching shipping cost. Please try again later.');
    }

    $data['ongkos'] = $cost['rajaongkir']['results'];

    if(Auth::user()->level == "distributor"){
        $data['pelanggans'] = Pelanggan::where('distributor_id', Auth::user()->id)->where('type', 'distributor')->get();
        $data['dropshippers'] = Pelanggan::where('type', 'dropshipper')->where('distributor_id', Auth::user()->id)->get();
    }elseif(Auth::user()->level == "reseller"){
        $data['pelanggans'] = Pelanggan::where('reseller_id', Auth::user()->id)->where('type', 'reseller')->get();
        $data['dropshippers'] = Pelanggan::where('type', 'dropshipper')->where('reseller_id', Auth::user()->id)->get();
    }elseif(Auth::user()->level == "agen"){
        $data['pelanggans'] = Pelanggan::where('agen_id', Auth::user()->id)->where('type', 'agen')->get();
        $data['dropshippers'] = Pelanggan::where('type', 'dropshipper')->where('agen_id', Auth::user()->id)->get();
    }elseif(Auth::user()->level == "sub agen"){
        $data['pelanggans'] = Pelanggan::where('subagen_id', Auth::user()->id)->where('type', 'sub agen')->get();
        $data['dropshippers'] = Pelanggan::where('type', 'dropshipper')->where('subagen_id', Auth::user()->id)->get();
    }

    return view('customer.checkout', $data);
} catch (\Exception $e) {
    // Handle other exceptions
    return back()->with('error', 'An error occurred during checkout: ' . $e->getMessage());
}
}
public function agen_checkout()
{
try {
    $session = session('cart');

    if ($session == null) {
        return back()->with('error', 'Your cart is empty. Please add items before checking out.');
    }

    $http = new \GuzzleHttp\Client;
    $prov = $http->get('https://api.rajaongkir.com/starter/province', [
        'headers' => [
            'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
        ]
    ]);

    $prov = json_decode((string) $prov->getBody(), true);
    $data['prov'] = $prov['rajaongkir']['results'];
    $data['pelanggans'] = Pelanggan::where('agen_id', Auth::user()->id)->where('type', 'agen')->get();

    $http = new \GuzzleHttp\Client;
    $berat = 0;
    $session = session()->get('cart');

    foreach ($session as $value) {
        $berat += $value['package_weight'];
    }

    $cost = Http::withHeaders([
        'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
    ])->post('https://pro.rajaongkir.com/api/cost', [
        'origin' => 23,
        'originType' => 'city',
        'destination' => Auth::user()->code_city,
        'destinationType' => 'subdistrict',
        'weight' => $berat,
        'courier' => 'jne'
    ]);

    if (!isset($cost['rajaongkir']['results'])) {
        throw new \Exception('Error fetching shipping cost. Please try again later.');
    }

    $data['ongkos'] = $cost['rajaongkir']['results'];
    $data['dropshippers'] = Pelanggan::where('type', 'dropshipper')->where('agen_id', Auth::user()->id)->get();

    return view('customer.agen-checkout', $data);
} catch (\Exception $e) {
    // Handle other exceptions
    return back()->with('error', 'An error occurred during checkout: ' . $e->getMessage());
}
}

public function subagen_checkout()
{
try {
    $session = session('cart');

    if ($session == null) {
        return back()->with('error', 'Your cart is empty. Please add items before checking out.');
    }

    $http = new \GuzzleHttp\Client;
    $prov = $http->get('https://api.rajaongkir.com/starter/province', [
        'headers' => [
            'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
        ]
    ]);

    $prov = json_decode((string) $prov->getBody(), true);
    $data['prov'] = $prov['rajaongkir']['results'];
    $data['pelanggans'] = Pelanggan::where('subagen_id', Auth::user()->id)->where('type', 'sub agen')->get();

    $http = new \GuzzleHttp\Client;
    $berat = 0;
    $session = session()->get('cart');

    foreach ($session as $value) {
        $berat += $value['package_weight'];
    }

    $cost = Http::withHeaders([
        'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
    ])->post('https://pro.rajaongkir.com/api/cost', [
        'origin' => 23,
        'originType' => 'city',
        'destination' => Auth::user()->code_city,
        'destinationType' => 'subdistrict',
        'weight' => $berat,
        'courier' => 'jne'
    ]);

    if (!isset($cost['rajaongkir']['results'])) {
        throw new \Exception('Error fetching shipping cost. Please try again later.');
    }

    $data['ongkos'] = $cost['rajaongkir']['results'];
    $data['dropshippers'] = Pelanggan::where('type', 'dropshipper')->where('subagen_id', Auth::user()->id)->get();

    return view('customer.subagen-checkout', $data);
} catch (\Exception $e) {
    // Handle other exceptions
    return back()->with('error', 'An error occurred during checkout: ' . $e->getMessage());
}
}
public function checkout_buynow(Request $request)
{
    $size = Variations::where('id',$request->sizeId)->first();

        if($size->stok < 1){
            return back()->with('error','size out of stock');
        }
    $product = Product::where('id',$size->product_id)->first();
    if (Auth::check()) {
        $harga = $size->reseller_price;
        $harga_dropshipper = $size->dropshipper_price;
        $reseller = User::where('id',Auth::user()->id)->first();
        $commission = $reseller->grade->profit;
        $rpCommission = $harga * ($commission / 100);
        $rpCommissionDropshipper = $harga_dropshipper * ($commission / 100);
    }else{
        $harga = $size->price;
        $harga_dropshipper = 0;
        $commission = 0;
        $rpCommission = 0;
        $rpCommissionDropshipper = 0;
    }
    $buynow = [
        'product_id' => $size->product_id,
        'color' => $size->warna,
        'variations_id' => $size->id,
        // 'image' => $image,
        'nama' => $size->product->item_group_name,
        'price' => $size->price,
        'dropshipper_price' =>  $size->dropshipper_price,
        'size' => $size->size,
        'package_weight' => $size->product->package_weight,
        'package_height' => $size->product->package_height,
        'package_width' => $size->product->package_width,
        'package_length' => $size->product->package_length,
        'package_content' => $size->product->package_content,
        'qty' => $request->input('qty'),
        'price_total' => $size->price * $request->input('qty'),
        'dropshipper_price_total' => $size->dropshipper_price * $request->input('qty'),
        'commission' => $commission,
        'rpCommission' => $rpCommission,
        'rpCommissionDropshipper' => $rpCommissionDropshipper,
    ];
    session()->put('buynow', $buynow);
    session()->save();

    $http = new \GuzzleHttp\Client;
    $prov = $http->get('https://api.rajaongkir.com/starter/province',[
        'headers' => [
            'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
        ]
    ]);
    $prov = json_decode((string)$prov->getBody(), true);
    $data['prov'] = $prov['rajaongkir']['results'];
    $data['pelanggans'] = Pelanggan::where('reseller_id',Auth::user()->id)->where('type','reseller')->get();
    $http = new \GuzzleHttp\Client;
    $berat = session('buynow')['package_weight'];
        $cost = Http::withHeaders([
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ])->post('https://pro.rajaongkir.com/api/cost',[
                    'origin'=>23,
                    'originType'=>'city',
                    'destination'=>Auth::user()->code_city,
                    'destinationType'=>'subdistrict',
                    'weight'=>$berat,
                    'courier'=>'jne'
            ]);
    $data['ongkos'] = $cost['rajaongkir']['results'];
    $data['dropshippers'] = Pelanggan::where('type','dropshipper')->where('reseller_id',AUth::user()->id)->get();
    return view('customer.checkout-buynow',$data);
}
public function contact()
{
    return view('customer.contact');
}

public function daftar()
{
    return view('customer.daftar');
}

public function faq()
{
    $data['faq'] = Faq::all();
    return view('customer.faq',$data);
}

public function gabung()
{
    return view('customer.gabung-reseller');
}

public function index()
{
    $data['banner'] = Banner::all();
    $data['category'] = Category::all();
    $data['content'] = Banner::all();
    $data['video'] = Video::all();
    // $data['product'] = Product::all();
    $data['product'] = Product::where('is_active',true)->get();
    $data['rekomedasi'] = Product::where('recomendation',true)->get();
    return view('customer.index',$data);
}

public function konfirmasi()
{
    return view('customer.konfirmasi');
}

public function katalog()
{
    $data['product'] = Product::where('is_active',true)->get();
    $data['jmlprdk'] = Product::where('is_active',true)->count();
    return view('customer.katalog',$data);
}
public function getFilteredProducts(Request $request)
{
    try {
        $category = $request->input('category');
        $sort = $request->input('sort');

        $query = Product::where('is_active', true);

        if ($category) {
            $query->where('item_category_id', $category); // Gantilah 'category_column_name' dengan nama kolom kategori yang sesuai di dalam tabel produk
        }

        if ($sort == 'sell_price') {
            $query->orderBy('sell_price', 'asc');
        } elseif ($sort == 'asc') {
            $query->orderBy('item_group_name', 'asc');
        } elseif ($sort == 'desc') {
            $query->orderBy('item_group_name', 'desc');
        }

        $products = $query->get();

        return response()->json(['products' => $products]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function informasi()
{
    return view('customer.informasi');
}

public function login()
{
    return view('customer.login');
}
public function sub_category($id)
{
    $category = Category::find($id);

    if ($category) {
        $subCategories = $category->sub;
        return response()->json(['subCategories' => $subCategories]);
    }

    return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
}
public function product($id)
{
    $data['product'] = Product::with('variation')->where('id',$id)->first();
    $data['count'] = Variations::where('product_id', $data['product']->id)->sum('stok');
    // dd($count);
    $data['lainya'] = Product::where('category_name',$data['product']->category_name)->get();
    $product = $data['product'];
    $variations = json_decode($product->variation);
    $data['variation'] = $variations;
    $colors = [];
    $warna = [];
    // dd($variations);
    foreach ($variations as $variation) {
        $colors[] = $variation->warna;
    }

    // Langkah 2: Hapus duplikat warna
    $uniqueColors = array_unique($colors);

    // Langkah 3: Tampilkan warna yang unik
    foreach ($uniqueColors as $color) {
        $warna[] = $color;
    }
    $data['colors'] = $warna;
    // dd($warna);
    // dd($variations);

    // Langkah 4: Gunakan array_filter untuk menyaring data dengan warna "merah"
    // $filteredVariations = array_filter($variations, function ($variation) {
    //     return $variation->warna === "merah";
    // });

    // Ini akan menampilkan data dengan warna "merah" saja
    // dd($filteredVariations);

    return view('customer.product',$data);
}
public function riwayat_pesanan(){
    if(Auth::user()->level == 'reseller'){
        $data['pending'] = Transaction::where('reseller_id',Auth::user()->id)->where('status','pending')->get();
        $data['paid'] = Transaction::where('reseller_id',Auth::user()->id)->where('status','paid')->get();
        $data['expired'] = Transaction::where('reseller_id',Auth::user()->id)->where('status','expired')->get();
    }elseif(Auth::user()->level == 'sub agen'){
        $data['pending'] = Transaction::where('sub_agen_id',Auth::user()->id)->where('status','pending')->get();
        $data['paid'] = Transaction::where('sub_agen_id',Auth::user()->id)->where('status','paid')->get();
        $data['expired'] = Transaction::where('sub_agen_id',Auth::user()->id)->where('status','expired')->get();
    }
    elseif(Auth::user()->level == 'agen'){
        $data['pending'] = Transaction::where('agen_id',Auth::user()->id)->where('status','pending')->get();
        $data['paid'] = Transaction::where('agen_id',Auth::user()->id)->where('status','paid')->get();
        $data['expired'] = Transaction::where('agen_id',Auth::user()->id)->where('status','expired')->get();
    }
    return view('riwayat-pesanan',$data);
}
public function poin(){
    return view('poin');
}
public function customer_pelanggan(){
return view('customer-pelanggan');
}
public function addToCart(Request $request) {
    $size = Variations::where('id',$request->input('sizeId'))->first(); // Ambil ukuran berdasarkan ID yang dipilih dari checkbox
    $cart = session()->get('cart');
    $found = false;
    // Mengecek apakah produk dengan detail yang sama sudah ada di session
    // if ($cart) {
    //     foreach ($cart as &$item) {
    //         if ($item['size_id'] === $size->id) {
    //             $item['qty'] += 1;
    //             if (Auth::check()) {
    //                 $item['price_total'] = $item['reseller_price'] * $item['qty'];
    //             }else{
    //                 $item['price_total'] = $item['price'] * $item['qty'];
    //             }
    //             $found = true;
    //             break;
    //         }
    //     }
    // }
    if (Auth::check()) {
        if (auth()->user()->level == 'distributor') {
            $harga = $size->distributor_price;
            $harga_dropshipper = $size->dropshipper_price;
            $reseller = User::where('id',Auth::user()->id)->first();
            $commission = $reseller->grade->profit;

            $rpCommission = $harga * ($commission / 100);
            $rpCommissionDropshipper = $harga_dropshipper * ($commission / 100);
        }else if(auth()->user()->level == 'agen'){
            $harga = $size->agen_price;
            $harga_dropshipper = $size->agen_price;
            $reseller = User::where('id',Auth::user()->id)->first();
            $commission = $reseller->grade->profit;

            $rpCommission = $harga * ($commission / 100);
            $rpCommissionDropshipper = $harga_dropshipper * ($commission / 100);
        }
        else if(auth()->user()->level == 'sub agen'){
            $harga = $size->sub_agen_price;
            $harga_dropshipper = $size->sub_agen_price;
            $reseller = User::where('id',Auth::user()->id)->first();
            $commission = $reseller->grade->profit;

            $rpCommission = $harga * ($commission / 100);
            $rpCommissionDropshipper = $harga_dropshipper * ($commission / 100);
        }
        else if(auth()->user()->level == 'reseller'){
            $harga = $size->reseller_price;
            $harga_dropshipper = $size->dropshipper_price;
            $reseller = User::where('id',Auth::user()->id)->first();
            $commission = $reseller->grade->profit;

            $rpCommission = $harga * ($commission / 100);
            $rpCommissionDropshipper = $harga_dropshipper * ($commission / 100);
        }
    }else{
        $harga = $size->price;
        $harga_dropshipper = 0;
        $commission = 0;
        $rpCommission = 0;
        $rpCommissionDropshipper = 0;
    }
    if (!$found) {
        $cart[] = [
            'product_id' => $size->product_id,
            'color' => $size->warna,
            'variations_id' => $size->id,
            // 'image' => $image,
            'nama' => $size->product->item_group_name,
            'price' => $harga,
            'dropshipper_price' => $harga_dropshipper,
            'size' => $size->size,
            'package_weight' => $size->product->package_weight,
            'package_height' => $size->product->package_height,
            'package_width' => $size->product->package_width,
            'package_length' => $size->product->package_length,
            'package_content' => $size->product->package_content,
            'qty' => $request->input('qty'),
            'price_total' => $harga * $request->input('qty'),
            'dropshipper_price_total' => $harga_dropshipper * $request->input('qty'),
            'commission' => $commission,
            'rpCommission' => $rpCommission,
            'rpCommissionDropshipper' => $rpCommissionDropshipper,
            'item_id' => $size->item_id,
            'item_code' => $size->item_code,
        ];
    }
        session()->put('cart', $cart);
        session()->save();

    return response()->json(['message' => 'Product added to cart.']);
}
public function remove_cart($index){
    $cart = session()->get('cart');
    unset($cart[$index]);
    session()->put('cart',$cart);
    return redirect()->back();
}
public function confirmshipping(Request $request){
    $http = new \GuzzleHttp\Client();

    $name = $request->name;
    $phone = $request->no_telp;
    $province_code = $request->province_code;
    $city_code = $request->city_code;
    $subdistrict_code = $request->subdistrict_code;
    $pos_code = $request->pos_code;
    $full_address = $request->full_address;

    $response = $http->get('https://pro.rajaongkir.com/api/subdistrict',[
        'query'=> [
            'city'=>$city_code
        ],
        'headers' => [
            'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
        ]
    ]);
    $json = json_decode((string)$response->getBody(), true);
    $subdistrict = $json['rajaongkir']['results'];
    $filter = collect($subdistrict)->where('subdistrict_id', '=', $subdistrict_code);
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
            "contact_name"=> $name,
            "contact_type"=> 0,
            "primary_contact"=> $name,
            "contact_position"=> "Umum",
            "email"=> "",
            "phone"=> $phone,
            "mobile"=> $phone,
            "fax"=> "null",
            "npwp"=> "null",
            "payment_term"=> -1,
            "notes"=> "PELANGGAN-WEBSTORE",
            "s_address"=> $full_address,
            "s_area"=> "null",
            "s_city"=>  $shipping['city'],
            "s_province"=>  $shipping['province'],
            "s_post_code"=> "46462",
            "b_address"=> $full_address,
            "b_area"=> "null",
            "b_city"=>  $shipping['city'],
            "b_province"=> $shipping['province'],
            "b_post_code"=> "null",
            "is_dropshipper"=> false,
            "is_reseller"=> false,
            "category_id"=> -1,
            "nik"=> null
        ],
        'headers' => [
            'Authorization' => 'Bearer ' . token(),
            'Accept'        => 'application/json',
        ],
    ]);
    $jube = json_decode((string)$jubelio->getBody(), true);
        $user = [
            'contact_id'=>$jube['contact_id'],
            'name'=>$name,
            'no_telp'=>$phone,
            'province'=>$shipping['province'],
            'code_provinsi'=>$shipping['province_code'],
            'kota'=>$shipping['city'],
            'code_kota'=>$shipping['city_code'],
            'kecamatan'=>$shipping['subdistrict'],
            'code_kecamatan'=>$shipping['subdistrict_code'],
            'alamat_lengkap'=>$full_address
        ];
        session()->put('user',$user);
        session()->save();
        // dd(session('user'));
        return redirect('/shipping');
}
public function confirmshipping_buynow(Request $request){
    $http = new \GuzzleHttp\Client();

    $name = $request->name;
    $phone = $request->no_telp;
    $province_code = $request->province_code;
    $city_code = $request->city_code;
    $subdistrict_code = $request->subdistrict_code;
    $pos_code = $request->pos_code;
    $full_address = $request->full_address;

    $response = $http->get('https://pro.rajaongkir.com/api/subdistrict',[
        'query'=> [
            'city'=>$city_code
        ],
        'headers' => [
            'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
        ]
    ]);
    $json = json_decode((string)$response->getBody(), true);
    $subdistrict = $json['rajaongkir']['results'];
    $filter = collect($subdistrict)->where('subdistrict_id', '=', $subdistrict_code);
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
        $user = [
            'name'=>$name,
            'no_telp'=>$phone,
            'province'=>$shipping['province'],
            'code_provinsi'=>$shipping['province_code'],
            'kota'=>$shipping['city'],
            'code_kota'=>$shipping['city_code'],
            'kecamatan'=>$shipping['subdistrict'],
            'code_kecamatan'=>$shipping['subdistrict_code'],
            'alamat_lengkap'=>$full_address
        ];
        session()->put('user',$user);
        session()->save();
        // dd(session('user'));
        return redirect('/shipping-buynow');
}
public function shipping()
{
    $http = new \GuzzleHttp\Client;
    $berat = 0;
    $session = session()->get('cart');
    foreach ($session as $value) {
        $berat += $value['package_weight'];
    }
        $cost = Http::withHeaders([
            'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
        ])->post('https://pro.rajaongkir.com/api/cost',[
                'origin'=>23,
                'originType'=>'city',
                'destination'=>session()->get('user')['code_kota'],
                'destinationType'=>'subdistrict',
                'weight'=>$berat,
                'courier'=>'jne'
        ]);
    $data['ongkos'] = $cost['rajaongkir']['results'];
    // dd($data['ongkos']);
    $total = 0;
    foreach(session('cart') as $key => $value) {
        $total += $value['price_total'];
    }
    $data['total'] = $total;
    $data['discount'] = 0;

    return view('customer.shipping')->with($data);
}

public function shipping_buynow()
{
    $http = new \GuzzleHttp\Client;
    $berat = 0;
    $session = session()->get('cart');
        $cost = Http::withHeaders([
            'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
        ])->post('https://pro.rajaongkir.com/api/cost',[
                'origin'=>23,
                'originType'=>'city',
                'destination'=>session()->get('user')['code_kota'],
                'destinationType'=>'subdistrict',
                'weight'=>session('buynow')['package_weight'],
                'courier'=>'jne'
        ]);
    $data['ongkos'] = $cost['rajaongkir']['results'];
    // dd($data['ongkos']);
    $total = 0;
    $data['total'] = $total;
    $data['discount'] = 0;

    return view('customer.shipping-buynow')->with($data);
}
public function tentangKami()
{
    return view('customer.tentang-kami');
}

public function wishlist()
{
    return view('customer.wishlist');
}
public function reseller_transaction(Request $request)
{
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    $data['paket'] = GradeReseller::all();
    // dd($data['paket']);
    $query = User::where('status','active')->where('level','reseller');
    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }
    $data['reseller'] = $query->get();
    return view('reseller-transaction',$data);
}
public function update_level(Request $request, $id)
{
    User::where('id',$id)->update([
        'grade_id'=>$request->grade_id
    ]);
    return back();
}
public function reseller_comission(Request $request)
{
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    $query = User::where('status','active')->where('level','reseller');

    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    $data['reseller'] = $query->get();

    return view('reseller-comission',$data);
}
public function commission_reseller(Request $request)
{
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    $komisi = Comission::where('reseller_id',Auth::user()->id)->where('status','success')->latest()->first();
    if ($komisi == null) {
        $data['komisi'] = 0;
    }else{
        $data['komisi'] = $komisi->saldo_akhir;
    }
    $query = Transaction::where('reseller_id',Auth::user()->id)->where('status','paid');

    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }
    $data['transaction'] = $query->get();
    return view('commission-reseller',$data);

}
public function dashboard_reseller(Request $request)
{
    $data['transaksi'] = Transaction::where('reseller_id',Auth::user()->id)->where('type','reseller')->where('status','paid')->count();
    $data['dropshipper'] = Transaction::where('reseller_id',Auth::user()->id)->where('type','dropshipper')->where('status','paid')->count();
    return view('dashboard-reseller',$data);
}
public function transaction_reseller(Request $request)
{
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    $query = Transaction::where('reseller_id', Auth::user()->id)
        ->where('type', 'reseller')
        ->where('status', 'paid');

    // Cek apakah tanggal awal dan akhir telah diberikan
    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    $data['transaction'] = $query->get();

    return view('transaction-reseller', $data);
}
public function transaction_dropshipper(Request $request)
{
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    $query = Transaction::where('reseller_id',Auth::user()->id)->where('type','dropshipper')->where('status','paid');
    // Cek apakah tanggal awal dan akhir telah diberikan
    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }
    $data['transaction'] = $query->get();

    return view('transaction-dropshipper',$data);
}
public function reseller()
{
    $data['activeResellers'] = User::where('status','active')->where('level','reseller')->get();
    $data['inactiveResellers'] = User::where('status','non active')->where('level','reseller')->get();
    return view('list-reseller',$data);
}
public function agen()
{
    $data['activeResellers'] = User::where('status','active')->where('level','agen')->get();
    $data['inactiveResellers'] = User::where('status','non active')->where('level','agen')->get();
    return view('list-agen',$data);
}
public function distributor()
{
    $data['activeResellers'] = User::where('status','active')->where('level','distributor')->get();
    $data['inactiveResellers'] = User::where('status','non active')->where('level','distributor')->get();
    return view('list-distributor',$data);
}
public function reseller_verify($id){
    User::where('id',$id)->update([
        'status'=>'active'
    ]);
    return back()->with('success','successfully verifyication reseller');
}
public function agen_verify($id){
    User::where('id',$id)->update([
        'status'=>'active'
    ]);
    return back()->with('success','successfully verifyication reseller');
}
public function distributor_verify($id){
    User::where('id',$id)->update([
        'status'=>'active'
    ]);
    return back()->with('success','successfully verifyication reseller');
}
public function information()
{
    $session = session()->get('cart');
    if ($session == null) {
        return back();
    }
    $http = new \GuzzleHttp\Client;
    $prov = $http->get('https://api.rajaongkir.com/starter/province',[
        'headers' => [
            'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
        ]
    ]);
    $prov = json_decode((string)$prov->getBody(), true);
    $data['prov'] = $prov['rajaongkir']['results'];
    $total = 0;
    foreach($session as $key => $value) {
        $total += $value['price_total'];
    }
    $data['total'] = $total;
    $data['discount'] = 0;
    return view('customer.informasi',$data);
}
public function city(Request $request){
    $selectedProvinceId = $request->input('selectedProvinceId');
    $http = new \GuzzleHttp\Client;
    $response = $http->get('https://pro.rajaongkir.com/api/city',[
        'query'=>[
            'province'=>$selectedProvinceId
        ],
        'headers' => [
            'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
        ]
    ]);
    return response()->json(json_decode((string) $response->getBody(), true), 200);
}
public function substrict(Request $request){
    $selectedCityId = $request->input('selectedCityId');
    $http = new \GuzzleHttp\Client;
    $response = $http->get('https://pro.rajaongkir.com/api/subdistrict',[
        'query'=>[
            'city'=>$selectedCityId
        ],
        'headers' => [
            'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
        ]
    ]);
    return response()->json(json_decode((string) $response->getBody(), true), 200);
}
public function getconfirmation($code_inv)
{
    $transaksi = Transaction::where('code_inv',$code_inv)->first();
    $data['user'] = User::where('id',$transaksi->user_id)->first();
    // dd($transaksi);

    $data['cost'] = $transaksi->cost;
    $data['transaksi'] = $transaksi;
    $data['order'] = DetailTransaction::where('transaksi_id',$transaksi->id)->get();
    $carbon = Carbon::now();
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        $params = array(
        'transaction_details' => array(
            'order_id' => $transaksi->code_inv,
            'gross_amount' => $transaksi->total_bayar + $transaksi->cost,
        )
    );
        $data['snap_token'] = \Midtrans\Snap::getSnapToken($params);
        $data['carts'] = session('cart');
        return view('customer.konfirmasi',$data);

}
public function getconfirmation_buynow($code_inv)
{
        $transaksi = Transaction::where('code_inv',$code_inv)->first();
        $data['user'] = User::where('id',$transaksi->user_id)->first();

    $data['cost'] = $transaksi->cost;
    $data['transaksi'] = $transaksi;
    $data['order'] = DetailTransaction::where('transaksi_id',$transaksi->id)->get();
    $carbon = Carbon::now();
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        $params = array(
        'transaction_details' => array(
            'order_id' => $transaksi->code_inv,
            'gross_amount' => $transaksi->total_bayar + $transaksi->cost,
        )
    );
        $data['snap_token'] = \Midtrans\Snap::getSnapToken($params);
        $data['carts'] = session('buynow');
        return view('customer.konfirmasi_buynow',$data);

}
public function confirmation(Request $request)
{
    $http = new \GuzzleHttp\Client();
        $session_order = session()->get('cart');

        $data['cart'] = $session_order;
        $berat = 0;
        $total_bayar = 0;
        foreach ($session_order as $key => $value) {
            $berat += $value['package_weight'];
            $total_bayar += $value['price_total'];
        }

            $cost = Http::withHeaders([
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ])->post('https://pro.rajaongkir.com/api/cost',[
                'origin'=>23,
                'originType'=>'city',
                'destination'=>session()->get('user')['code_kota'],
                'destinationType'=>'subdistrict',
                'weight'=>$berat,
                'courier'=>'jne'
            ]);
        $ongkos = $cost['rajaongkir']['results'];
        // dd($ongkos);
        $raja_ongkir = [];
        foreach ($ongkos as $key => $ongkir) {
            foreach ($ongkir['costs'] as $key => $value) {
                foreach ($value['cost'] as $key => $cost) {
                    $raja_ongkir[] = [
                        'service'=>$value['service'],
                        'value'=>$cost['value'],
                        'total_bayar'=>$total_bayar
                    ];
                }
            }
        }
        // dd($ongkos);
        $filter_ongkir = collect($raja_ongkir)->where('service', '=', $request->cost);
        $json = json_decode($filter_ongkir);
        // dd($json);
        foreach($filter_ongkir as $filter){
            $service = $filter['service'];
            $isi = $filter['value'];
            $bayar = $filter['total_bayar'];
        }
        $posShipping = 'JNE '.$service;
        if(Auth::check()){
            $type = 'distributor';
        }else{
            $type = 'default';
        }
            $user =  Pelanggan::create([
                    'type'=>$type,
                    'contact_id'=>session()->get('user')['contact_id'],
                    'name'=>session()->get('user')['name'],
                    'no_telp'=>session()->get('user')['no_telp'],
                    'province'=>session()->get('user')['province'],
                    'city'=>session()->get('user')['kota'],
                    'subdistrict'=>session()->get('user')['kecamatan'],
                    'code_province'=>session()->get('user')['code_provinsi'],
                    'code_city'=>session()->get('user')['code_kota'],
                    'code_substrict'=>session()->get('user')['code_kecamatan'],
                    'address'=>session()->get('user')['alamat_lengkap']
                ]);
                $item = [];
                foreach ($session_order as $value) {
                    $item[] = [
                        "amount"=> $value['price_total'],
                        "tax_amount"=> "0",
                        "disc_amount"=> "0",
                        "disc"=> "0",
                        "qty_in_base"=> $value['qty'],
                        "unit"=> "baju",
                        "price"=> $value['price'],
                        "tax_id"=> 1,
                        "item_id"=> $value['item_id'],
                        "location_id"=> "-1",
                        "salesorder_detail_id"=> "0",
                        "serial_no"=> $value['item_code'],
                        "description"=> "PERCOBAAN",
                        "shipper"=> $posShipping,
                        "channel_order_detail_id"=> "null"
                    ];
                }
                $code_transaksi = "WEBSTORE-".Carbon::now()->format('d-m-y')."-".uniqid();
                $waktu = Carbon::now();
                // Menggunakan metode format untuk mengubah format waktu
                $waktuDiformat = $waktu->format('Y-m-d\TH:i:s.u\Z');
                $jubelio = $http->post('https://api2.jubelio.com/sales/orders/',[
                    'json'=> [
                        "salesorder_id"=> 0,
                        "salesorder_no"=> $code_transaksi,
                        "contact_id"=> $user['contact_id'],
                        "customer_name"=> $user['name'],
                        "transaction_date"=> $waktuDiformat,
                        "sub_total"=> $bayar,
                        "total_disc"=> "0",
                        "total_tax"=> "0",
                        "grand_total"=> "0",
                        "location_id"=> "-1",
                        "source"=> "1",
                        "add_fee"=> "0",
                        "add_disc"=> "0",
                        "service_fee"=> 0,
                        "items" => $item,
                        "is_tax_included"=> "false",
                        "note"=> "null",
                        "ref_no"=> "<string>",
                        "is_canceled"=> "false",
                        "cancel_reason"=> "Tidak Punya Uang",
                        "cancel_reason_detail"=> "Tidak Punya Uang",
                        "channel_status"=> "pending",
                        "shipping_cost"=> $isi,
                        "insurance_cost"=> "1000",
                        "is_paid"=> "false",
                        "shipping_full_name"=> $user['name'],
                        "shipping_phone"=> $user['phone'],
                        "shipping_address"=> $user['aolamat_lengkap'],
                        "shipping_area"=> $user['subdistrict'],
                        "shipping_city"=> $user['city'],
                        "shipping_province"=> $user['province'],
                        "shipping_post_code"=> "null",
                        "shipping_country"=> "Indonesia",
                        "salesmen_id"=> null,
                        "store_id"=> null,
                        "payment_method"=> "null"
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . token(),
                        'Accept'        => 'application/json',
                    ],
                ]);
                $jube = json_decode((string)$jubelio->getBody(), true);
                 // Create Transaksi
                 $transaksi = Transaction::create([
                     'id' => $jube['id'],
                     'code_inv' => $code_transaksi,
                     'type' => 'default',
                     'reseller_id' => null,
                     'dropshipper_id' => null,
                     'pelanggan_id' => $user->id,
                     'total_bayar' => $bayar,
                     'payment_method' => 'Cash',
                     'shipping_method' => $posShipping,
                     'cost' => $isi,
                     'status' => 'pending',
                     'processed' => true,
                    ]);
                    $data['transaksi'] = $transaksi;
                    // Create Detail Order
                    $transaksi_id = $transaksi->id;
                    $order = [];
                    foreach ($session_order as $value) {
                        $order[] = DetailTransaction::create([
                            'transaksi_id'=>$transaksi_id,
                            'user_id'=>$user->id,
                            'product_id'=>$value['product_id'],
                            'variations_id'=>$value['variations_id'],
                            'total'=>$value['price_total'],
                            'qty'=>$value['qty']
                            ]);
                    }
                    return redirect('/confirmation'.'/'.$transaksi->code_inv);
 }
public function confirmation_buynow(Request $request)
{
    $session_order = session()->get('buynow');

    $bayar = 0;
    $isi = 0;
        $cost = Http::withHeaders([
            'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
        ])->post('https://pro.rajaongkir.com/api/cost',[
            'origin'=>23,
            'originType'=>'city',
            'destination'=>session()->get('user')['code_kota'],
            'destinationType'=>'subdistrict',
            'weight'=>$session_order['package_weight'],
            'courier'=>'jne'
        ]);
    $ongkos = $cost['rajaongkir']['results'];
    // dd($ongkos);
    $raja_ongkir = [];
    foreach ($ongkos as $key => $ongkir) {
        foreach ($ongkir['costs'] as $key => $value) {
            foreach ($value['cost'] as $key => $cost) {
                $raja_ongkir[] = [
                    'service'=>$value['service'],
                    'value'=>$cost['value'],
                    'total_bayar'=>$session_order['price_total']
                ];
            }
        }
    }
    // dd($ongkos);
    $filter_ongkir = collect($raja_ongkir)->where('service', '=', $request->cost);
    $json = json_decode($filter_ongkir);
    // dd($json);
    foreach($filter_ongkir as $filter){
        $service = $filter['service'];
        $isi = $filter['value'];
        $bayar = $filter['total_bayar'];
    }
    $posShipping = 'JNE - '.$service;
        $user =  Pelanggan::create([
                'type'=>'default',
                'name'=>session()->get('user')['name'],
                'no_telp'=>session()->get('user')['no_telp'],
                'province'=>session()->get('user')['province'],
                'city'=>session()->get('user')['kota'],
                'subdistrict'=>session()->get('user')['kecamatan'],
                'code_province'=>session()->get('user')['code_provinsi'],
                'code_city'=>session()->get('user')['code_kota'],
                'code_substrict'=>session()->get('user')['code_kecamatan'],
                'address'=>session()->get('user')['alamat_lengkap']
            ]);
            // Create Transaksi
            $code_transaksi = "INV-".Carbon::now()->format('d-m-y')."-".uniqid();
            $transaksi = Transaction::create([
                'code_inv' => $code_transaksi,
                'type' => 'default',
                'reseller_id' => null,
                'dropshipper_id' => null,
                'pelanggan_id' => $user->id,
                'total_bayar' => $bayar,
                'payment_method' => 'Cash',
                'shipping_method' => $posShipping,
                'cost' => $isi,
                'status' => 'pending',
                'processed' => true,
                ]);
                $data['transaksi'] = $transaksi;
                // Create Detail Order
                $transaksi_id = $transaksi->id;
                $order = [];
                    $order[] = DetailTransaction::create([
                        'transaksi_id'=>$transaksi_id,
                        'user_id'=>$user->id,
                        'product_id'=>$session_order['product_id'],
                        'variations_id'=>$session_order['variations_id'],
                        'total'=>$session_order['price_total'],
                        'qty'=>$session_order['qty']
                        ]);
                return redirect('/confirmation-buynow'.'/'.$transaksi->code_inv);
}
// post pelanggan
public function post_pelanggan(Request $request)
{
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

        $jubelio = $http->post('https://api2.jubelio.com/contacts/', [
            'json' => [
                "contact_name"=> $requestData['name'],
                "contact_type"=> 0,
                "primary_contact"=> $requestData['name'],
                "contact_position"=> "DROPSHIPPER",
                "email"=> $requestData['email'],
                "phone"=> $requestData['no_telp'],
                "mobile"=> $requestData['no_telp'],
                "fax"=> "null",
                "npwp"=> "null",
                "payment_term"=> -1,
                "notes"=> "PELANGGAN-WEBSTORE",
                "s_address"=>$requestData['full_address'],
                "s_area"=> "null",
                "s_city"=>  $shipping['city'],
                "s_province"=> $shipping['province'],
                "s_post_code"=> $shipping['post_code'],
                "b_address"=> $requestData['full_address'],
                "b_area"=> "null",
                "b_city"=>  $shipping['city'],
                "b_province"=> $shipping['province'],
                "b_post_code"=> $requestData['post_code'],
                "is_dropshipper"=> false,
                "is_reseller"=> false,
                "category_id"=> 6,
                "nik"=> $requestData['nik'],
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . token(),
                'Accept' => 'application/json',
            ],
        ]);

        $jube = json_decode((string) $jubelio->getBody(), true);

        if(Auth::user()->level == "agen"){
            $a = Auth::user()->id;
            $d = null;
            $r = null;
            $sa = null;
            $type = 'agen';
        }elseif(Auth::user()->level == "distributor"){
            $d = Auth::user()->id;
            $a = null;
            $r = null;
            $sa = null;
            $type = 'distributor';
        }elseif(Auth::user()->level == "reseller"){
            $r = Auth::user()->id;
            $sa = null;
            $a = null;
            $d = null;
            $type = 'reseller';
        }elseif(Auth::user()->level == "sub agen"){
            $sa = Auth::user()->id;
            $d = null;
            $a = null;
            $r = null;
            $type = 'sub_agen';
        }
        // Membuat entri baru di tabel Pelanggan
        $pelanggan = Pelanggan::create([
            'contact_id' => $jube['contact_id'],
            'type' => $type,
            'distributor_id' => $d,
            'reseller_id' => $r,
            'agen_id' => $a,
            'subagen_id' => $sa,
            'name' => $requestData['name'],
            'no_telp' => $requestData['no_telp'],
            'province' => $shipping['province'],
            'city' => $shipping['city'],
            'subdistrict' => $shipping['subdistrict'],
            'kelurahan' => $requestData['kelurahan'],
            'code_province' => $shipping['province_code'],
            'code_city' => $shipping['city_code'],
            'code_subdistrict' => $shipping['subdistrict_code'],
            'contact_lain' => null,
            'address' => $requestData['full_address']
        ]);
        // dd($pelanggan);
        return back()->with('success','successfully added member');
}
public function post_agen(Request $request){
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

    // Membuat entri baru di tabel Pelanggan
    $pelanggan = Pelanggan::create([
        'type' => 'agen',
        'agen_id' => Auth::user()->id,
        'name' => $requestData['name'],
        'no_telp' => $requestData['no_telp'],
        'province' => $shipping['province'],
        'city' => $shipping['city'],
        'subdistrict' => $shipping['subdistrict'],
        'kelurahan' => $requestData['kelurahan'],
        'code_province' => $shipping['province_code'],
        'code_city' => $shipping['city_code'],
        'code_subdistrict' => $shipping['subdistrict_code'],
        'contact_lain' => $requestData['kontak_lain'],
        'address' => $requestData['full_address']
    ]);
    // dd($pelanggan);
    return back()->with('success','successfully added member');
}
public function post_dropshipper(Request $request)
{
    try {
        $http = new \GuzzleHttp\Client();

        // Membaca data dari request
        $requestData = $request->all();

        $response = $http->get('https://pro.rajaongkir.com/api/subdistrict', [
            'query' => [
                'city' => $requestData['city_code']
            ],
            'headers' => [
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ]
        ]);

        $json = json_decode((string) $response->getBody(), true);
        $subdistrict = $json['rajaongkir']['results'];
        $filter = collect($subdistrict)->where('subdistrict_id', '=', $requestData['subdistrict_code']);
        $shipping = [];

        foreach ($filter as $value) {
            $shipping = [
                'province_code' => $value['province_id'],
                'city_code' => $value['city_id'],
                'subdistrict_code' => $value['subdistrict_id'],
                'city' => $value['city'],
                'province' => $value['province'],
                'subdistrict' => $value['subdistrict_name']
            ];
        }

        $jubelio = $http->post('https://api2.jubelio.com/contacts/', [
            'json' => [
                "contact_name"=> $requestData['name'],
                "contact_type"=> 0,
                "primary_contact"=> $requestData['name'],
                "contact_position"=> "DROPSHIPPER",
                "email"=> $requestData['email'],
                "phone"=> $requestData['no_telp'],
                "mobile"=> $requestData['no_telp'],
                "fax"=> "null",
                "npwp"=> "null",
                "payment_term"=> -1,
                "notes"=> "DROPSHIPPER-WEBSTORE",
                "s_address"=>$requestData['full_address'],
                "s_area"=> "null",
                "s_city"=>  $shipping['city'],
                "s_province"=> $shipping['province'],
                "s_post_code"=> $shipping['post_code'],
                "b_address"=> $requestData['full_address'],
                "b_area"=> "null",
                "b_city"=>  $shipping['city'],
                "b_province"=> $shipping['province'],
                "b_post_code"=> $requestData['post_code'],
                "is_dropshipper"=> true,
                "is_reseller"=> false,
                "category_id"=> 6,
                "nik"=> $requestData['nik'],
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . token(),
                'Accept' => 'application/json',
            ],
        ]);

        $jube = json_decode((string) $jubelio->getBody(), true);
        if(Auth::user()->level == "agen"){
            $a = Auth::user()->id;
            $d = null;
            $r = null;
            $sa = null;
        }elseif(Auth::user()->level == "distributor"){
            $d = Auth::user()->id;
            $a = null;
            $r = null;
            $sa = null;
        }elseif(Auth::user()->level == "reseller"){
            $r = Auth::user()->id;
            $sa = null;
            $a = null;
            $d = null;
        }elseif(Auth::user()->level == "sub agen"){
            $sa = Auth::user()->id;
            $d = null;
            $a = null;
            $r = null;
        }
        // Membuat entri baru di tabel Pelanggan
        $dropshipper = Pelanggan::create([
            'contact_id' => $jube['contact_id'],
            'type' => 'dropshipper',
            'distributor_id' => $d,
            'reseller_id' => $r,
            'agen_id' => $a,
            'subagen_id' => $sa,
            'name' => $requestData['name'],
            'email' => $requestData['email'],
            'no_telp' => $requestData['no_telp'],
            'province' => $shipping['province'],
            'city' => $shipping['city'],
            'subdistrict' => $shipping['subdistrict'],
            'kelurahan' => $requestData['kelurahan'],
            'code_province' => $shipping['province_code'],
            'code_city' => $shipping['city_code'],
            'code_subdistrict' => $shipping['subdistrict_code'],
            'contact_lain' => null,
            'address' => $requestData['full_address'],
        ]);

        return back()->with('success', 'Successfully added Dropshipper');
    } catch (\Exception $e) {
        // Handle other exceptions
        return back()->with('error', 'An error occurred while adding Dropshipper: ' . $e->getMessage());
    }
}
public function post_sub_agen(Request $request)
{
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

    // Membuat entri baru di tabel Pelanggan
    $sub_agen = Pelanggan::create([
        'type' => 'sub_agen',
        'agen_id' => Auth::user()->id,
        'name' => $requestData['name'],
        'no_telp' => $requestData['no_telp'],
        'province' => $shipping['province'],
        'city' => $shipping['city'],
        'subdistrict' => $shipping['subdistrict'],
        'kelurahan' => $requestData['kelurahan'],
        'code_province' => $shipping['province_code'],
        'code_city' => $shipping['city_code'],
        'code_subdistrict' => $shipping['subdistrict_code'],
        'contact_lain' => $requestData['kontak_lain'],
        'address' => $requestData['full_address'],
    ]);
    // dd($pelanggan);
    return back()->with('success','successfully added Sub Agen');
}
public function getPelangganInfo($id)
{
    $pelanggan = Pelanggan::where('id', $id)->first();
    $berat = 0;
    $session = session()->get('cart');
    foreach ($session as $value) {
        $berat += $value['package_weight'];
    }

    $cost = Http::withHeaders([
        'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
    ])->post('https://pro.rajaongkir.com/api/cost', [
        'origin' => 23,
        'originType' => 'city',
        'destination' => $pelanggan->code_city,
        'destinationType' => 'subdistrict',
        'weight' => $berat,
        'courier' => 'jne'
    ]);
    $data['ongkos'] = $cost['rajaongkir']['results'];
    $data['pelanggan'] = $pelanggan;

    $total = 0;
    foreach (session('cart') as $key => $value) {
        $total += $value['price_total'];
    }
    $data['total'] = $total;

    if ($pelanggan) {
        return response()->json($data);
    } else {
        return response()->json(['error' => 'Pelanggan not found'], 404);
    }
}
public function post_pesanan(Request $request){
    $http = new \GuzzleHttp\Client();

    $session_order = session()->get('cart');
    $dataPelanggan = Pelanggan::where('id',$request->pelanggan_id)->first();
    if ($dataPelanggan == null) {
        $city = auth()->user()->code_city;
    }else{
        $city = $dataPelanggan->code_city;
    }
        $data['cart'] = $session_order;
        $berat = 0;
        $total_bayar = 0;
        $total_bayar_dropshipper = 0;
        $komisi = 0;
        foreach ($session_order as $key => $value) {
            $berat += $value['package_weight'];
            $total_bayar += $value['price_total'];
            $total_bayar_dropshipper += $value['dropshipper_price_total'];
            $komisi += $value['rpCommission'];
        }
            $cost = Http::withHeaders([
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ])->post('https://pro.rajaongkir.com/api/cost',[
                'origin'=>23,
                'originType'=>'city',
                'destination'=>$city,
                'destinationType'=>'subdistrict',
                'weight'=>$berat,
                'courier'=>'jne'
            ]);
        $ongkos = $cost['rajaongkir']['results'];
        $raja_ongkir = [];
        foreach ($ongkos as $key => $ongkir) {
            foreach ($ongkir['costs'] as $key => $value) {
                foreach ($value['cost'] as $key => $cost) {
                    $raja_ongkir[] = [
                        'service'=>$value['service'],
                        'value'=>$cost['value'],
                        'total_bayar'=>$total_bayar,
                        'total_bayar_dropshipper'=>$total_bayar_dropshipper,
                    ];
                }
            }
        }
        // dd($ongkos);
        $filter_ongkir = collect($raja_ongkir)->where('service', '=', $request->cost);
        $json = json_decode($filter_ongkir);
        // dd($json);
        foreach($filter_ongkir as $filter){
            $service = $filter['service'];
            $isi = $filter['value'];

            $bayar = $filter['total_bayar'];
            $bayar_dropshipper = $filter['total_bayar_dropshipper'];
        }
        $posShipping = 'JNE '.$service;
                 // Create payment reseller
                    if(auth()->user()->level == 'reseller'){
                        $r = Auth::user()->id;
                        $a = null;
                        $sa = null;
                        $dis = null;
                        $payment = PaymentReseller::where('reseller_id',Auth::user()->id)->where('status','progress')->latest()->first();
                    }elseif(auth()->user()->level == 'agen'){
                        $a = Auth::user()->id;
                        $sa = null;
                        $r = null;
                        $dis = null;
                        $payment = PaymentReseller::where('agen_id',Auth::user()->id)->where('status','progress')->latest()->first();
                    }
                    elseif(auth()->user()->level == 'sub agen'){
                        $sa = Auth::user()->id;
                        $r = null;
                        $a = null;
                        $dis = null;
                        $payment = PaymentReseller::where('subagen_id',Auth::user()->id)->where('status','progress')->latest()->first();
                    }else{
                        $sa = null;
                        $r = null;
                        $a = null;
                        $dis = Auth::user()->id;
                        $payment = PaymentReseller::where('distributor_id',Auth::user()->id)->where('status','progress')->latest()->first();
                    }
                if ($payment == null) {
                  $pay = PaymentReseller::create([
                    'code_invoice'=>"WEBSTORE-".Carbon::now()->format('d-m-y')."-".uniqid(),
                    'total'=>1000,
                    'status'=>'progress',
                    'reseller_id'=>$r,
                    'agen_id'=>$a,
                    'distributor_id'=>$dis,
                    'subagen_id'=>$sa
                  ]);
                 }else{
                    $pay = $payment;
                 }

                 // Create Transaksi
                 if (auth()->user()->level == 'reseller') {
                    if ($request->has('isDropshipper') == true) {
                        $pembayaran =$bayar_dropshipper;
                        $type = 'dropshipper';
                        $dropshipper = $request->dropshipper;
                        $user_dropshipper = Pelanggan::where('id',$dropshipper)->first();
                        $contact_id = $user_dropshipper->contact_id;
                        $customer_name = $user_dropshipper->name;
                    }else{
                        $type = 'reseller';
                        $dropshipper = null;
                        $pembayaran =$bayar;
                        $contact_id = auth()->user()->contact_id;
                        $customer_name = auth()->user()->first_name;
                    }
                }elseif (auth()->user()->level == 'sub agen') {
                    if ($request->has('isDropshipper') == true) {
                        $pembayaran =$bayar_dropshipper;
                        $type = 'dropshipper';
                        $dropshipper = $request->dropshipper;
                        $user_dropshipper = Pelanggan::where('id',$dropshipper)->first();
                        $contact_id = $user_dropshipper->contact_id;
                        $customer_name = $user_dropshipper->name;
                    }else{
                        $type = 'sub_agen';
                        $dropshipper = null;
                        $pembayaran =$bayar;
                        $contact_id = auth()->user()->contact_id;
                        $customer_name = auth()->user()->first_name;
                    }
                }
                elseif (auth()->user()->level == 'agen'){
                    if ($request->has('isDropshipper') == true) {
                        $pembayaran =$bayar_dropshipper;
                        $type = 'dropshipper';
                        $dropshipper = $request->dropshipper;
                        $user_dropshipper = Pelanggan::where('id',$dropshipper)->first();
                        $contact_id = $user_dropshipper->contact_id;
                        $customer_name = $user_dropshipper->name;
                    }
                    else{
                        $type = 'agen';
                        $dropshipper = null;
                        $pembayaran =$bayar;
                        $contact_id = auth()->user()->contact_id;
                        $customer_name = auth()->user()->first_name;
                     }
                }else{
                    if ($request->has('isDropshipper') == true) {
                        $pembayaran =$bayar_dropshipper;
                        $type = 'dropshipper';
                        $dropshipper = $request->dropshipper;
                        $user_dropshipper = Pelanggan::where('id',$dropshipper)->first();
                        $contact_id = $user_dropshipper->contact_id;
                        $customer_name = $user_dropshipper->name;
                    }
                    else{
                        $type = 'distributor';
                        $dropshipper = null;
                        $pembayaran =$bayar;
                        $contact_id = auth()->user()->contact_id;
                        $customer_name = auth()->user()->first_name;
                     }

                }

                //  dd($customer_name);
                $code = Kupon::where('code',$request->kupon)->first();
                if ($request->kupon) {
                    if ($code == null) {
                        return back()->with('error','Kupon Tidak ditemkan');
                    }else{
                        $pembayaran_akhir = $pembayaran - $code->value ;
                    }
                }else{
                    $pembayaran_akhir = $pembayaran;
                }
                $reseller = User::where('id',Auth::user()->id)->first();
                $commission = $reseller->grade->profit;
                 $code_transaksi = "WEBSTORE-".Carbon::now()->format('d-m-y')."-".uniqid();
                 if(auth()->user()->level == 'agen'){
                    $res_id = null;
                    $agen_id = Auth::user()->id;
                    $sub_agen_id = null;
                    $dropshipper = null;
                    $distributor_id = null;
                 }elseif(auth()->user()->level == 'reseller'){
                    $res_id = Auth::user()->id;
                    $agen_id = null;
                    $sub_agen_id = null;
                    $distributor_id = null;
                 }elseif(auth()->user()->level == 'sub agen'){
                    $res_id = null;
                    $agen_id = null;
                    $distributor_id = null;
                    $sub_agen_id = Auth::user()->id;
                 }else{
                    $res_id = null;
                    $agen_id = null;
                    $distributor_id = Auth::user()->id;
                    $sub_agen_id = null;
                 }
                    $item = [];
                    foreach ($session_order as $value) {
                        if ($request->has('isDropshipper') == true) {
                            $total_value = $value['dropshipper_price_total'];
                        }else{
                            $total_value = $value['price_total'];
                        }
                        $item[] = [
                            "amount"=> $total_value,
                            "tax_amount"=> "0",
                            "disc_amount"=> "0",
                            "disc"=> "0",
                            "qty_in_base"=> $value['qty'],
                            "unit"=> "baju",
                            "price"=> $value['price'],
                            "tax_id"=> 1,
                            "item_id"=> $value['item_id'],
                            "location_id"=> "-1",
                            "salesorder_detail_id"=> "0",
                            "serial_no"=> $value['item_code'],
                            "description"=> "PERCOBAAN",
                            "shipper"=> $posShipping,
                            "channel_order_detail_id"=> "null"
                        ];
                    }
                    $waktu = Carbon::now();
                    // Menggunakan metode format untuk mengubah format waktu
                    $waktuDiformat = $waktu->format('Y-m-d\TH:i:s.u\Z');
                    $jubelio = $http->post('https://api2.jubelio.com/sales/orders/',[
                        'json'=> [
                            "salesorder_id"=> 0,
                            "salesorder_no"=> $code_transaksi,
                            "contact_id"=> $contact_id,
                            "customer_name"=> $customer_name,
                            "transaction_date"=> $waktuDiformat,
                            "sub_total"=> $pembayaran_akhir,
                            "total_disc"=> "0",
                            "total_tax"=> "0",
                            "grand_total"=> $pembayaran_akhir + $isi,
                            "location_id"=> "-1",
                            "source"=> "1",
                            "add_fee"=> "0",
                            "add_disc"=> "0",
                            "service_fee"=> 0,
                            "items" => $item,
                            "is_tax_included"=> "false",
                            "note"=> $request->catatan,
                            "ref_no"=> "<string>",
                            "is_canceled"=> "false",
                            "cancel_reason"=> "Tidak Punya Uang",
                            "cancel_reason_detail"=> "Tidak Punya Uang",
                            "channel_status"=> "pending",
                            "shipping_cost"=> $isi,
                            "insurance_cost"=> "0",
                            "is_paid"=> "false",
                            "shipping_full_name"=> $request->penerima,
                            "shipping_phone"=> auth()->user()->no_wa,
                            "shipping_address"=> $request->full_address,
                            "shipping_area"=> $request->kecamatan,
                            "shipping_city"=> $request->kota,
                            "shipping_province"=> auth()->user()->province,
                            "shipping_post_code"=> "64642",
                            "shipping_country"=> "Indonesia",
                            "salesmen_id"=> null,
                            "store_id"=> null,
                            "payment_method"=> "null"
                        ],
                        'headers' => [
                            'Authorization' => 'Bearer ' . token(),
                            'Accept'        => 'application/json',
                        ],
                    ]);
                    $jube = json_decode((string)$jubelio->getBody(), true);
                     $transaksi = Transaction::create([
                     'id' => $jube['id'],
                     'code_inv' => $code_transaksi,
                     'type' => $type,
                     'payment_reseller' => $pay->id,
                     'reseller_id' =>$res_id,
                     'distributor_id' =>$distributor_id,
                     'agen_id' => $agen_id,
                     'sub_agen_id' => $sub_agen_id,
                     'dropshipper_id' => $dropshipper,
                     'pelanggan_id' => $request->pelanggan_id,
                     'total_bayar' => $pembayaran_akhir,
                     'shipping_method' => $posShipping,
                     'cost' => $isi,
                     'status' => 'progress',
                     'penerima' => $request->penerima,
                     'provinsi' => $request->provinsi,
                     'kota' => $request->kota,
                     'kecamatan' => $request->kecamatan,
                     'alamat_lengkap' => $request->full_address,
                     'catatan' => $request->catatan,
                     'processed' => false,
                     'commission'=>$komisi
                    ]);
                    $data['transaksi'] = $transaksi;
                    // Create Detail Order
                    $order = [];
                    foreach ($session_order as $value) {
                        if ($request->has('isDropshipper') == true) {
                            $total_value = $value['dropshipper_price_total'];
                        }else{
                            $total_value = $value['price_total'];
                        }
                        $order[] = DetailTransaction::create([
                            'transaksi_id'=> $jube['id'],
                            'user_id'=>Auth::user()->id,
                            'product_id'=>$value['product_id'],
                            'variations_id'=>$value['variations_id'],
                            'total'=>$total_value,
                            'qty'=>$value['qty'],
                            'commission'=>$value['rpCommission']
                            ]);
                    }
                 if(auth()->user()->level == 'reseller'){
                     $com = Comission::where('reseller_id', Auth::user()->id)->latest()->first();
                    }elseif(auth()->user()->level == 'agen'){
                     $com = Comission::where('agen_id', Auth::user()->id)->latest()->first();
                    }elseif(auth()->user()->level == 'sub agen'){
                        $com = Comission::where('subagen_id', Auth::user()->id)->latest()->first();
                    }
                    if ($com == null) {
                        $saldo_awal = $transaksi->commission;
                        $saldo_akhir = $saldo_awal;
                    }else{
                        $saldo_awal = $com->saldo_akhir;
                        $saldo_akhir = $transaksi->commission + $saldo_awal;
                    }

                    Comission::create([
                        'reseller_id'=>$res_id,
                        'subagen_id'=>$sub_agen_id,
                        'agen_id'=>$agen_id,
                        'type'=>'komisi',
                        'transaction_id'=>$jube['id'],
                        'saldo_awal'=>$saldo_awal,
                        'value'=>$transaksi->commission,
                        'saldo_akhir'=>$saldo_akhir,
                    ]);
                if(auth()->user()->level == 'agen'){
                        $transaksis = Transaction::where('agen_id',Auth::user()->id)->where('status','progress')->get();
                        if ($transaksi->dropshipper_id == null) {
                            $tran = Transaction::where('type','agen')->where('agen_id',Auth::user()->id)->where('status','progress')->get();
                        }else{
                            $tran = Transaction::where('type','dropshipper')->where('agen_id',Auth::user()->id)->where('status','progress')->get();
                        }
                }elseif(auth()->user()->level == 'sub agen'){
                    $transaksis = Transaction::where('sub_agen_id',Auth::user()->id)->where('status','progress')->get();
                    if ($transaksi->dropshipper_id == null) {
                        $tran = Transaction::where('type','sub_agen')->where('sub_agen_id',Auth::user()->id)->where('status','progress')->get();
                    }else{
                        $tran = Transaction::where('type','dropshipper')->where('sub_agen_id',Auth::user()->id)->where('status','progress')->get();
                    }
                }elseif(auth()->user()->level == 'distributor'){
                    $transaksis = Transaction::where('distributor_id',Auth::user()->id)->where('status','progress')->get();
                    if ($transaksi->dropshipper_id == null) {
                        $tran = Transaction::where('type','distributor')->where('distributor_id',Auth::user()->id)->where('status','progress')->get();
                    }else{
                        $tran = Transaction::where('type','dropshipper')->where('distributor_id',Auth::user()->id)->where('status','progress')->get();
                    }
                }
                else{
                        $transaksis = Transaction::where('reseller_id',Auth::user()->id)->where('status','progress')->get();
                        if ($transaksi->dropshipper_id == null) {
                            $tran = Transaction::where('type','reseller')->where('reseller_id',Auth::user()->id)->where('status','progress')->get();
                        }else{
                            $tran = Transaction::where('type','dropshipper')->where('reseller_id',Auth::user()->id)->where('status','progress')->get();
                        }
                }
                    $total_bayar = 0;
                    foreach ($transaksis as $key => $trans) {
                        $total_bayar += ($trans['total_bayar']+$trans['cost']);
                    }
                    $pay->update([
                        'total'=>$total_bayar
                    ]);
                    // $transaksi = [
                    //     'code_inv' => $code_transaksi,
                    //     'type' => 'reseller',
                    //     'reseller_id' =>Auth::user()->id,
                    //     'dropshipper_id' => null,
                    //     'pelanggan_id' => $request->pelanggan_id,
                    //     'total_bayar' => $bayar,
                    //     'payment_method' => 'Cash',
                    //     'shipping_method' => $posShipping,
                    //     'cost' => $isi,
                    //     'status' => 'pending',
                    //     'penerima' => $request->penerima,
                    //     'kota' => $request->kota,
                    //     'kecamatan' => $request->kecamatan,
                    //     'alamat' => $request->full_address,
                    //     'processed' => true,
                    //     'detailtransaksi'=>$session_order
                    //    ];
                    //    session()->put('transaksi',$transaksi);
                    //    $data['transaksi'] = session('transaksi');
                    //    dd($data['transaksi']);
                    if ($code == null) {
                        # code...
                        return redirect('/pesanan');
                    }else{
                        return redirect('/pesanan')->with('success','berhasil menggunakan kupon, potongan sebesar'.$code->value);
                    }
    }
    public function post_pesanan_buynow(Request $request){
        //     $com = Comission::where('reseller_id', Auth::user()->id)->latest()->first();
        // dd($com->saldo_awal);
            $session_order = session()->get('buynow');
            $dataPelanggan = Pelanggan::where('id',$request->pelanggan_id)->first();
            // dd($request->pelanggan_id);
                $data['cart'] = $session_order;

                    $berat = $session_order['package_weight'];
                    $total_bayar = $session_order['price_total'];
                    $total_bayar_dropshipper = $session_order['dropshipper_price_total'];
                    $komisi = $session_order['rpCommission'];

                    $cost = Http::withHeaders([
                        'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
                    ])->post('https://pro.rajaongkir.com/api/cost',[
                        'origin'=>23,
                        'originType'=>'city',
                        'destination'=>$dataPelanggan->code_city,
                        'destinationType'=>'subdistrict',
                        'weight'=>$berat,
                        'courier'=>'jne'
                    ]);
                $ongkos = $cost['rajaongkir']['results'];
                $raja_ongkir = [];
                foreach ($ongkos as $key => $ongkir) {
                    foreach ($ongkir['costs'] as $key => $value) {
                        foreach ($value['cost'] as $key => $cost) {
                            $raja_ongkir[] = [
                                'service'=>$value['service'],
                                'value'=>$cost['value'],
                                'total_bayar'=>$total_bayar,
                                'total_bayar_dropshipper'=>$total_bayar_dropshipper,
                            ];
                        }
                    }
                }
                // dd($ongkos);
                $filter_ongkir = collect($raja_ongkir)->where('service', '=', $request->cost);
                $json = json_decode($filter_ongkir);
                // dd($json);
                foreach($filter_ongkir as $filter){
                    $service = $filter['service'];
                    $isi = $filter['value'];

                    $bayar = $filter['total_bayar'];
                    $bayar_dropshipper = $filter['total_bayar_dropshipper'];
                }
                $posShipping = 'JNE - '.$service;
                         // Create payment reseller
                         $payment = PaymentReseller::where('reseller_id',Auth::user()->id)->where('status','progress')->latest()->first();
                         if ($payment == null) {
                          $pay = PaymentReseller::create([
                            'code_invoice'=>"INV-".Carbon::now()->format('d-m-y')."-".uniqid(),
                            'total'=>1000,
                            'status'=>'progress',
                            'reseller_id'=>Auth::user()->id,
                          ]);
                         }else{
                            $pay = $payment;
                         }
                         // Create Transaksi
                         if ($request->has('isDropshipper') == true) {
                            $pembayaran =$bayar_dropshipper;
                            $type = 'dropshipper';
                            $dropshipper = $request->dropshipper;
                        }else{
                            $type = 'reseller';
                            $dropshipper = null;
                            $pembayaran =$bayar;

                         }
                        //  dd($type);
                        $code = Kupon::where('code',$request->kupon)->first();
                        if ($request->kupon) {
                            if ($code == null) {
                                return back()->with('error','Kupon Tidak ditemkan');
                            }else{
                                $pembayaran_akhir = $pembayaran - $code->value ;
                            }
                        }else{
                            $pembayaran_akhir = $pembayaran;
                        }
                        $reseller = User::where('id',Auth::user()->id)->first();
                        $commission = $reseller->grade->profit;
                         $code_transaksi = "INV-".Carbon::now()->format('d-m-y')."-".uniqid();
                         $transaksi = Transaction::create([
                             'code_inv' => $code_transaksi,
                             'type' => $type,
                             'payment_reseller' => $pay->id,
                             'reseller_id' =>Auth::user()->id,
                             'dropshipper_id' => $dropshipper,
                             'pelanggan_id' => $request->pelanggan_id,
                             'total_bayar' => $pembayaran_akhir,
                             'shipping_method' => $posShipping,
                             'cost' => $isi,
                             'status' => 'progress',
                             'penerima' => $request->penerima,
                             'provinsi' => $request->provinsi,
                             'kota' => $request->kota,
                             'kecamatan' => $request->kecamatan,
                             'alamat_lengkap' => $request->full_address,
                             'catatan' => $request->catatan,
                             'processed' => false,
                             'commission'=>$komisi
                            ]);
                            $data['transaksi'] = $transaksi;
                            // Create Detail Order
                            $transaksi_id = $transaksi->id;
                                if ($request->has('isDropshipper') == true) {
                                    $total_value = $session_order['dropshipper_price_total'];
                                }else{
                                    $total_value = $session_order['price_total'];
                                }
                                 DetailTransaction::create([
                                    'transaksi_id'=>$transaksi_id,
                                    'user_id'=>Auth::user()->id,
                                    'product_id'=>$session_order['product_id'],
                                    'variations_id'=>$session_order['variations_id'],
                                    'total'=>$total_value,
                                    'qty'=>$session_order['qty'],
                                    'commission'=>$session_order['rpCommission']
                                    ]);
                            $com = Comission::where('reseller_id', Auth::user()->id)->latest()->first();
                            if ($com == null) {
                                $saldo_awal = $transaksi->commission;
                                $saldo_akhir = $saldo_awal;
                            }else{
                                $saldo_awal = $com->saldo_akhir;
                                $saldo_akhir = $transaksi->commission + $saldo_awal;
                            }
                            Comission::create([
                                'reseller_id'=>Auth::user()->id,
                                'type'=>'komisi',
                                'transaction_id'=>$transaksi_id,
                                'saldo_awal'=>$saldo_awal,
                                'value'=>$transaksi->commission,
                                'saldo_akhir'=>$saldo_akhir,
                            ]);
                            if ($transaksi->reseller_id == null) {
                                if ($transaksi->sub_agen_id == null) {
                                $tran = Transaction::where('type','agen')->where('agen_id',Auth::user()->id)->where('status','progress')->get();
                                }else{
                                $tran = Transaction::where('type','sub_agen')->where('agen_id',Auth::user()->id)->where('status','progress')->get();
                                }
                            }else{
                                if ($transaksi->dropshipper_id == null) {
                                    $tran = Transaction::where('type','dropshipper')->where('reseller_id',Auth::user()->id)->where('status','progress')->get();
                                    }else{
                                    $tran = Transaction::where('type','reseller')->where('reseller_id',Auth::user()->id)->where('status','progress')->get();
                                    }
                            }
                            $total_bayar = 0;
                            foreach ($tran as $key => $trans) {
                                $total_bayar += ($trans['total_bayar']+$trans['cost']);
                            }
                            $pay->update([
                                'total'=>$total_bayar
                            ]);
                            // $transaksi = [
                            //     'code_inv' => $code_transaksi,
                            //     'type' => 'reseller',
                            //     'reseller_id' =>Auth::user()->id,
                            //     'dropshipper_id' => null,
                            //     'pelanggan_id' => $request->pelanggan_id,
                            //     'total_bayar' => $bayar,
                            //     'payment_method' => 'Cash',
                            //     'shipping_method' => $posShipping,
                            //     'cost' => $isi,
                            //     'status' => 'pending',
                            //     'penerima' => $request->penerima,
                            //     'kota' => $request->kota,
                            //     'kecamatan' => $request->kecamatan,
                            //     'alamat' => $request->full_address,
                            //     'processed' => true,
                            //     'detailtransaksi'=>$session_order
                            //    ];
                            //    session()->put('transaksi',$transaksi);
                            //    $data['transaksi'] = session('transaksi');
                            //    dd($data['transaksi']);
                            if ($code == null) {
                                # code...
                                return redirect('/pesanan');
                            }else{
                                return redirect('/pesanan')->with('success','berhasil menggunakan kupon, potongan sebesar'.$code->value);
                            }
            }
    public function pesanan()
    {
        if(auth()->user()->level == 'reseller'){
            $data['transaction'] = Transaction::where('reseller_id',Auth::user()->id)->where('status','progress')->get();
            $data['count'] = Transaction::where('reseller_id',Auth::user()->id)->where('status','progress')->count();
            $data['payment'] = PaymentReseller::where('reseller_id',Auth::user()->id)->where('status','progress')->first();
        }elseif(auth()->user()->level == 'sub agen'){
            $data['transaction'] = Transaction::where('sub_agen_id',Auth::user()->id)->where('status','progress')->get();
            $data['count'] = Transaction::where('sub_agen_id',Auth::user()->id)->where('status','progress')->count();
            $data['payment']  = PaymentReseller::where('subagen_id',Auth::user()->id)->where('status','progress')->first();
        }elseif(auth()->user()->level == 'distributor'){
            $data['transaction'] = Transaction::where('distributor_id',Auth::user()->id)->where('status','progress')->get();
            $data['count'] = Transaction::where('distributor_id',Auth::user()->id)->where('status','progress')->count();
            $data['payment']  = PaymentReseller::where('distributor_id',Auth::user()->id)->where('status','progress')->first();
        }else{
            $data['transaction'] = Transaction::where('agen_id',Auth::user()->id)->where('status','progress')->get();
            $data['count'] = Transaction::where('agen_id',Auth::user()->id)->where('status','progress')->count();
            $data['payment']  = PaymentReseller::where('agen_id',Auth::user()->id)->where('status','progress')->first();
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        $params = array(
        'transaction_details' => array(
            'order_id' => $data['payment']->code_invoice,
            'gross_amount' => $data['payment']->total
            )
        );
        $data['snap_token'] = \Midtrans\Snap::getSnapToken($params);
        return view('customer.pesanan',$data);
    }
    public function pr(Request $request)
        {
            $isChecked = $request->input('isChecked');
            $transaksi =Transaction::where('reseller_id',Auth::user()->id)->where('status','pending')->get();
                $total = 0;
                foreach ($transaksi as $key => $value) {
                    $total = $value['total_bayar']+$value['cost'];
                }
                $payment = PaymentReseller::create([
                    'code_invoice'=>'INV-'.Carbon::now()->format('d-m-y')."-".uniqid(),
                    'total'=>$total
                ]);
                    // Transaction::where('reseller_id',Auth::user()->id)->where('status','pending')->update([
                    //     'payment_resseller'=>$payment->code_inv
                    // ]);
                 // Set your Merchant Server Key
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                // Set sanitization on (default)
                \Midtrans\Config::$isSanitized = true;
                // Set 3DS transaction for credit card to true
                \Midtrans\Config::$is3ds = true;
                $params = array(
                'transaction_details' => array(
                    'order_id' => $payment->code_inv,
                    'gross_amount' => $total
                )
            );
                $data = \Midtrans\Snap::getSnapToken($params);

            // Lakukan pembaruan data atau tindakan lain yang diperlukan

            return response()->json(['snap_token' => $data]);
        }
        public function buynow(Request $request){
            $size = Variations::where('id',$request->sizeId)->first();
            dd($size);
            if($size->stok < 1){
                return back()->with('error','size out of stock');
            }
        $product = Product::where('id',$size->product_id)->first();
        if (Auth::check()) {
            $harga = $size->reseller_price;
            $harga_dropshipper = $size->dropshipper_price;
            $reseller = User::where('id',Auth::user()->id)->first();
            $commission = $reseller->grade->profit;
            $rpCommission = $harga * ($commission / 100);
            $rpCommissionDropshipper = $harga_dropshipper * ($commission / 100);
        }else{
            $harga = $size->price;
            $harga_dropshipper = 0;
            $commission = 0;
            $rpCommission = 0;
            $rpCommissionDropshipper = 0;
        }
        $buynow = [
            'product_id' => $size->product_id,
            'color' => $size->warna,
            'variations_id' => $size->id,
            // 'image' => $image,
            'nama' => $size->product->item_group_name,
            'price' => $size->price,
            'dropshipper_price' =>  $size->dropshipper_price,
            'size' => $size->size,
            'package_weight' => $size->product->package_weight,
            'package_height' => $size->product->package_height,
            'package_width' => $size->product->package_width,
            'package_length' => $size->product->package_length,
            'package_content' => $size->product->package_content,
            'qty' => $request->input('qty'),
            'price_total' => $size->price * $request->input('qty'),
            'dropshipper_price_total' => $size->dropshipper_price * $request->input('qty'),
            'commission' => $commission,
            'rpCommission' => $rpCommission,
            'rpCommissionDropshipper' => $rpCommissionDropshipper,
        ];
        session()->put('buynow', $buynow);
        session()->save();
        // dd(session('buynow'));
        $http = new \GuzzleHttp\Client;
        $prov = $http->get('https://api.rajaongkir.com/starter/province',[
            'headers' => [
                'key' => '6b69e8eec2fcb0f60490f9d8051ecefd'
            ]
        ]);
        $prov = json_decode((string)$prov->getBody(), true);
        $data['prov'] = $prov['rajaongkir']['results'];
        return view('customer.informasi_buynow',$data);
        }
        public function lp(){
            $data['pelanggans'] = Pelanggan::where('type','default')->get();
            return view('pelanggan',$data);
        }
        protected $baseUri = 'https://api2.jubelio.com/';
        public function loginjubelio(Request $request){
            $email = $request->input('email');
            $password = $request->input('password');

            // Membangun data permintaan
            $data = [
                'email' => $email,
                'password' => $password,
            ];

            // Menggunakan Guzzle HTTP untuk melakukan permintaan POST ke API
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->post($this->baseUri . 'login', $data);

            $respone = $response->json();
            // Memeriksa apakah permintaan berhasil dan mengembalikan respons dari API
            if ($response->successful()) {
                session()->put('jubelio',$respone['token']);
                return redirect('/products');
            } else {
                // Memeriksa respons error jika permintaan gagal
                return response()->json(['error' => $response->json()], $response->status());
            }
        }
    }
