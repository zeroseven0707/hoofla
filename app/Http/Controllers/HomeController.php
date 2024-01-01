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
        $apiToken = config('app.api_token');

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
        $subCategories = explode(',', $request->input('sub_categories'));
        $sub = [];
        foreach ($subCategories as $key => $value) {
            $sub[] = $value;
        }
        // dd($sub);
        Category::create([
            'name'=>$request->name,
            'sub'=>$sub
        ]);
        return back();
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
        $session = session('cart');
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
        $data['pelanggans'] = Pelanggan::where('reseller_id',Auth::user()->id)->where('type','reseller')->get();
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
                    'destination'=>Auth::user()->code_city,
                    'destinationType'=>'subdistrict',
                    'weight'=>$berat,
                    'courier'=>'jne'
            ]);
        $data['ongkos'] = $cost['rajaongkir']['results'];
        $data['dropshippers'] = Pelanggan::where('type','dropshipper')->where('reseller_id',AUth::user()->id)->get();
        return view('customer.checkout',$data);
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
        return view('customer.gabung');
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
        return view('customer.katalog',$data);
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
    public function reseller_verify($id){
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
    public function post_pelanggan(Request $request){
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
            'type' => 'reseller',
            'reseller_id' => Auth::user()->id,
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
        public function post_dropshipper(Request $request){
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
            $dropshipper = Pelanggan::create([
                'type' => 'dropshipper',
                'reseller_id' => Auth::user()->id,
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
            return back()->with('success','successfully added Dropshipper');
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
//     $com = Comission::where('reseller_id', Auth::user()->id)->latest()->first();
// dd($com->saldo_awal);
    $session_order = session()->get('cart');
    $dataPelanggan = Pelanggan::where('id',$request->pelanggan_id)->first();
    // dd($request->pelanggan_id);
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
                    $order = [];
                    foreach ($session_order as $value) {
                        if ($request->has('isDropshipper') == true) {
                            $total_value = $value['dropshipper_price_total'];
                        }else{
                            $total_value = $value['price_total'];
                        }
                        $order[] = DetailTransaction::create([
                            'transaksi_id'=>$transaksi_id,
                            'user_id'=>Auth::user()->id,
                            'product_id'=>$value['product_id'],
                            'variations_id'=>$value['variations_id'],
                            'total'=>$total_value,
                            'qty'=>$value['qty'],
                            'commission'=>$value['rpCommission']
                            ]);
                    }
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
                    if ($transaksi->dropshipper_id == null) {
                        $tran = Transaction::where('type','reseller')->where('reseller_id',Auth::user()->id)->where('status','progress')->get();
                    }else{
                        $tran = Transaction::where('type','dropshipper')->where('reseller_id',Auth::user()->id)->where('status','progress')->get();
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
                            if ($transaksi->dropshipper_id == null) {
                                $tran = Transaction::where('type','reseller')->where('reseller_id',Auth::user()->id)->where('status','progress')->get();
                            }else{
                                $tran = Transaction::where('type','dropshipper')->where('reseller_id',Auth::user()->id)->where('status','progress')->get();
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
        $data['transaction'] = Transaction::where('reseller_id',Auth::user()->id)->where('status','progress')->get();
        $payment = PaymentReseller::where('reseller_id',Auth::user()->id)->where('status','progress')->first();
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
                             'order_id' => $payment->code_invoice,
                             'gross_amount' => $payment->total
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
