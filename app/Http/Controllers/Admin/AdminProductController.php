<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryCustomer;
use App\Models\Merk;
use App\Models\Pelanggan;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Variations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{

    public function dashboard(Request $request)
    {
        $data['transaksi'] = Transaction::count();
        $data['reseller'] = Pelanggan::where('type','reseller')->count();
        $data['dropshipper'] = Pelanggan::where('type','dropshipper')->count();
        $data['pelanggan'] = Pelanggan::where('type','default')->count();
        return view('dashboard',$data);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session('jubelio')) {
            $baseUrl = config('app.api_base_url');
            $apiToken = session('jubelio');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('jubelio'),
                'Accept' => 'application/json',
            ])->get($baseUrl . '/inventory/items/');
            $product = $response->json();
            // dd($product['statusCode']);
            $data['product'] = $product['data'];
            // dd($data['product']);
            $data['products'] = Product::all();
            $data['publish'] = Product::where('is_active',true)->get();
            $data['nopublish'] = Product::where('is_active',false)->get();
            return view('products',$data);
        }else{
            return view('customer.login-jubelio')->with('error','login akun jubelio terlebih dahulu');
        }
    }
    public function sync(){
        $baseUrl = config('app.api_base_url');
        $apiToken = session('jubelio');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('jubelio'),
            'Accept' => 'application/json',
        ])->get($baseUrl . '/inventory/items/');
        $product = $response->json();
        // dd($product['statusCode']);
        $data = $product['data'];
        // foreach($data as $item){
        //     $product_local = Product::where('id',$item['item_group_id'])->first();
        //     if($product_local == null){
        //         $images = [
        //             'slug'=>Str::random(20),
        //             'path'=>$item['thumbnail']
        //         ];
        //         $product = new Product();
        //         $product->id = $item['item_group_id'];
        //         $product->item_group_name = $item['item_name'];
        //         $product->description = $item['item_name'];
        //         $product->sell_this = true;
        //         $product->reseller_sell_price = $item['sell_price'];
        //         $product->dropshipper_sell_price = $item['sell_price'];
        //         $product->agen_sell_price = $item['sell_price'];
        //         $product->distributor_sell_price = $item['sell_price'];
        //         $product->buy_this = true;
        //         $product->stock_this = true;
        //         $product->sell_price = $item['sell_price'];
        //         $product->item_category_id =1;
        //         $product->images = $images;
        //         $product->brand_id = 1; // Ganti dengan nilai yang sesuai
        //         $product->is_active = false; // Ganti dengan nilai yang sesuai
        //         $product->export = true; // Ganti dengan nilai yang sesuai
        //         $product->package_content = null; // Ganti dengan nilai yang sesuai
        //         $product->package_weight = 1; // Ganti dengan nilai yang sesuai
        //         $product->package_height =1; // Ganti dengan nilai yang sesuai
        //         $product->package_width = 1; // Ganti dengan nilai yang sesuai
        //         $product->package_length = 1; // Ganti dengan nilai yang sesuai
        //         $product->brand_name = 'samsung'; // Ganti dengan nilai yang sesuai
        //         // Simpan ke database
        //         $product->save();
        //         // dd($item['variants'][0]['variation_values'][0]);
        //             foreach ($item['variants'] as $variations) {
        //                 Variations::create([
        //                     'slug' => Str::random(10),
        //                     'product_id' => $product->id,
        //                     'item_id' => $variations['item_id'],
        //                     'item_code' => $variations['item_code'],
        //                     'sku' => $variations['item_code'],
        //                     'warna' => $variations['variation_values'][0]['value'],
        //                     'size' =>$variations['variation_values'][1]['value'],
        //                     'price' => $products->sell_price,
        //                     'reseller_price' => $products->sell_price,
        //                     'dropshipper_price' => $products->sell_price,
        //                     'agen_price' => $products->sell_price,
        //                     'distributor_price' => $products->sell_price,
        //                     'stok' =>$variations['end_qty']
        //                 ]);
        //             }
        //     }else{
        //         Product::where('id',$item['item_group_id'])->update([

        //         ]);
        //     }
        // }
        foreach ($data as $item) {
            $distributor_query2 = CategoryCustomer::where('code',1)->first();
            $agen_query2 = CategoryCustomer::where('code',2)->first();
            $sub_agen_query2 = CategoryCustomer::where('code',3)->first();
            $reseller_query2 = CategoryCustomer::where('code',4)->first();
            $dropshipper_query2 = CategoryCustomer::where('code',6)->first();

            $harga_default = $item['sell_price'];
            // DISTRIBUTOR
            $distributor_diskon2 = $distributor_query2->persentase;
            $distributor2 = $harga_default * (1 - $distributor_diskon2 / 100);
            // AGEN
            $agen_diskon2 = $agen_query2->persentase;
            $agen2 = $harga_default * (1 - $agen_diskon2 / 100);
            // SUBAGEN
            $sub_agen_diskon2 = $sub_agen_query2->persentase;
            $sub_agen2 = $harga_default * (1 - $sub_agen_diskon2 / 100);
            // RESELLER
            $reseller_diskon2 = $reseller_query2->persentase;
            $reseller2 = $harga_default * (1 - $reseller_diskon2 / 100);
            // DROPSHIPPER
            $dropshipper_diskon2 = $dropshipper_query2->persentase;
            $dropshipper2 = $harga_default * (1 - $dropshipper_diskon2 / 100);

            $images = [
                'slug'=>Str::random(20),
                'path'=>$item['thumbnail']
            ];

            // Set atribut-atribut lainnya
            $product = Product::findOrNew($item['item_group_id']);
            $product->id = $item['item_group_id'];
            $product->item_group_name = $item['item_name'];
            $product->description = $item['item_name'];
            $product->sell_this = true;
            $product->reseller_sell_price = $reseller2;
            $product->dropshipper_sell_price = $dropshipper2;
            $product->agen_sell_price = $agen2;
            $product->sub_agen_sell_price = $sub_agen2;
            $product->distributor_sell_price = $distributor2;
            $product->buy_this = true;
            $product->stock_this = true;
            $product->sell_price = $item['sell_price'];
            $product->item_category_id = 1;
            $product->images = $images;
            $product->brand_id = 1;
            // $product->is_active = false;
            $product->export = true;
            $product->package_content = null;
            $product->package_weight = 1;
            $product->package_height = 1;
            $product->package_width = 1;
            $product->package_length = 1;
            $product->brand_name = 'samsung';

            $product->save();

            // Lakukan pembaruan untuk variasi jika diperlukan
            foreach ($item['variants'] as $variations) {
                $distributor_query = CategoryCustomer::where('code',1)->first();
                $agen_query = CategoryCustomer::where('code',2)->first();
                $sub_agen_query = CategoryCustomer::where('code',3)->first();
                $reseller_query = CategoryCustomer::where('code',4)->first();
                $dropshipper_query = CategoryCustomer::where('code',6)->first();

                $harga_awal = $variations['sell_price'];
                // DISTRIBUTOR
                $distributor_diskon = $distributor_query->persentase;
                $distributor = $harga_awal * (1 - $distributor_diskon / 100);
                // AGEN
                $agen_diskon = $agen_query->persentase;
                $agen = $harga_awal * (1 - $agen_diskon / 100);
                // SUBAGEN
                $sub_agen_diskon = $sub_agen_query->persentase;
                $sub_agen = $harga_awal * (1 - $sub_agen_diskon / 100);
                // RESELLER
                $reseller_diskon = $reseller_query->persentase;
                $reseller = $harga_awal * (1 - $reseller_diskon / 100);
                // DROPSHIPPER
                $dropshipper_diskon = $dropshipper_query->persentase;
                $dropshipper = $harga_awal * (1 - $dropshipper_diskon / 100);

                $slug = null;
                // Cari varian yang sudah ada
                $existingVariation = Variations::where('product_id', $product->id)
                    ->where('item_id', $variations['item_id'])
                    ->first();

                // Cek apakah varian sudah ada atau belum
                if ($existingVariation == null) {
                    // Jika varian belum ada, buat slug baru
                    $slug = Str::random(10);
                } else {
                    // Jika varian sudah ada, gunakan slug yang sudah ada
                    $slug = $existingVariation->slug;
                }
                $size = $variations['variation_values'][1]['value'] ?? 'null';
                $variation = Variations::updateOrCreate(
                    ['product_id' => $product->id, 'item_id' => $variations['item_id']],
                    [
                        'slug' => $slug,
                        'item_code' => $variations['item_code'],
                        'sku' => $variations['item_code'], // Jika item_code digunakan sebagai sku
                        'warna' => $variations['variation_values'][0]['value'],
                        'size' => $size,
                        'price' => $variations['sell_price'],
                        'reseller_price' => $reseller,
                        'dropshipper_price' => $dropshipper,
                        'agen_price' => $agen,
                        'sub_agen_price' => $sub_agen,
                        'distributor_price' => $distributor,
                        'stok' => $variations['end_qty']
                    ]
                );
            }
        }

        return back()->with('success','syncronize successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['merk'] = Merk::all();
        return view('product',$data);
    }
    public function upload($id)
    {
        $product = Product::where('id',$id)->first();
        if ($product->is_active == false) {
            $product->update([
                'is_active'=>true
            ]);
        }else{
            $product->update([
                'is_active'=>false
            ]);
        }
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export($id)
    {
        $baseUrl = config('app.api_base_url');
        $apiToken = session('jubelio');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($baseUrl . '/inventory/items/');
        $product = $response->json();
        $data['product'] = $product['data'];
        $filter = collect($data['product'])->where('item_group_id', '=', $id);
        $filters = json_decode($filter);
        // foreach ($filter[0]->variants as $key => $item) {
        //     foreach ($item->variation_values as $key => $value) {
        //         $colors[] = $value;

        //     }
        // }
        // $color = [];
        // $currentGroup = [];
        // foreach ($colors as $item) {
        //     if ($item->label == "Warna") {
        //         $currentGroup["Warna"] = $item->value;
        //     } elseif ($item->label == "Ukuran") {
        //         $currentGroup["Ukuran"] = $item->value;
        //         $color[] = $currentGroup;
        //         $currentGroup = [];
        //     }
        // }

        // dd($color);
        foreach ($filters as $item) {
            $filterss[] = $item;
        }
        $images = [
            'slug'=>Str::random(20),
            'path'=>$filterss[0]->thumbnail
        ];
        $product = new Product();
        $product->item_group_name = $filterss[0]->item_name;
        $product->description = $filterss[0]->item_name;
        $product->sell_this = true;
        $product->reseller_sell_price = $filterss[0]->sell_price;
        $product->dropshipper_sell_price = $filterss[0]->sell_price;
        $product->agen_sell_price = $filterss[0]->sell_price;
        $product->distributor_sell_price = $filterss[0]->sell_price;
        $product->buy_this = true;
        $product->stock_this = true;
        $product->sell_price = $filterss[0]->sell_price;
        $product->item_category_id =1;
        $product->images = $images;
        $product->brand_id = 1; // Ganti dengan nilai yang sesuai
        $product->is_active = false; // Ganti dengan nilai yang sesuai
        $product->export = true; // Ganti dengan nilai yang sesuai
        $product->package_content = null; // Ganti dengan nilai yang sesuai
        $product->package_weight = 1; // Ganti dengan nilai yang sesuai
        $product->package_height =1; // Ganti dengan nilai yang sesuai
        $product->package_width = 1; // Ganti dengan nilai yang sesuai
        $product->package_length = 1; // Ganti dengan nilai yang sesuai
        $product->brand_name = 'samsung'; // Ganti dengan nilai yang sesuai
        // Simpan ke database
        $product->save();
        foreach ($filterss[0]->variants as $key => $products) {
            foreach ($products->variation_values as $key => $value) {
                $colors[] = $value;
            }
        }
            $color = [];
            $currentGroup = [];
            foreach ($colors as $item) {
                if ($item->label == "Warna") {
                    $currentGroup["Warna"] = $item->value;
                } elseif ($item->label == "Ukuran") {
                    $currentGroup["Ukuran"] = $item->value;
                    $color[] = $currentGroup;
                    $currentGroup = [];
                }
            }
            foreach ($color as $key => $variations) {
                Variations::create([
                    'slug' => Str::random(10),
                    'product_id' => $product->id,
                    'sku' => $products->barcode,
                    'warna' => $variations['Warna'],
                    'size' =>$variations['Ukuran'],
                    'price' => $products->sell_price,
                    'reseller_price' => $products->sell_price,
                    'dropshipper_price' => $products->sell_price,
                    'agen_price' => $products->sell_price,
                    'distributor_price' => $products->sell_price,
                    'stok' =>100
                ]);
            }
            return back()->with('succcess','successfully Export product');
    }
     // Fungsi untuk menyimpan data ke database
    public function store(Request $request)
    {
        // dd($request->has('dibeli'));
        // Validasi input

        $images = [];
        foreach ($request->file('images') as $key => $image) {
            $images[] = [
                'slug'=>Str::random(20),
                'path'=>$image->store('product/')
            ];
        }
        $category = Category::find($request->category);
        $brand = Merk::where('code',$request->brand)->first();
        $category_name = $category->name;
        // dd($images);
        // Menyimpan data ke dalam database
        $product = new Product();
        $product->item_group_name = $request->input('product_name');
        $product->description = $request->input('description');
        $product->spesifikasi = $request->input('spesifikasi');
        $product->sell_this = $request->has('dijual');
        $product->reseller_sell_price = $request->input('hargaReseller');
        $product->dropshipper_sell_price = $request->input('hargaDropshipper');
        $product->agen_sell_price = $request->input('hargaAgen');
        $product->distributor_sell_price = $request->input('hargaDistributor');
        $product->buy_this = $request->has('dibeli');
        $product->stock_this = $request->has('disimpan');
        $product->sell_price = $request->input('hargaDefault');
        $product->item_category_id = $request->category;
        $product->category_name = $category_name;
        $product->sub_category_name = $request->sub_category_name;
        $product->images = $images;
        $product->brand_id = $brand->id; // Ganti dengan nilai yang sesuai
        $product->is_active = false; // Ganti dengan nilai yang sesuai
        $product->recomendation = $request->has('recomendation'); // Ganti dengan nilai yang sesuai
        $product->export = false; // Ganti dengan nilai yang sesuai
        $product->package_content = null; // Ganti dengan nilai yang sesuai
        $product->package_weight = $request->input('package_weight'); // Ganti dengan nilai yang sesuai
        $product->package_height =$request->input('package_height'); // Ganti dengan nilai yang sesuai
        $product->package_width = $request->input('package_width'); // Ganti dengan nilai yang sesuai
        $product->package_length = $request->input('package_length'); // Ganti dengan nilai yang sesuai
        $product->brand_name = $brand->name; // Ganti dengan nilai yang sesuai
        // Simpan ke database
        $product->save();
        $colors = $request->input('colors');
        $ukuran = $request->input('sizes');
        $price = $request->input('price');
        $reseller_price = $request->input('reseller_price');
        $dropshipper_price = $request->input('dropshipper_price');
        $agen_price = $request->input('agent_price');

        $distributor_price = $request->input('distributor_price');
        $stok = $request->input('stok');
        foreach ($request->input('sku') as $key => $item) {
            Variations::create([
                'slug' => Str::random(10),
                'product_id' => $product->id,
                'sku' => $item,
                'warna' => $colors[$key],
                'size' =>$ukuran[$key],
                'price' => $price[$key],
                'reseller_price' => $reseller_price[$key],
                'dropshipper_price' => $dropshipper_price[$key],
                'agen_price' => $agen_price[$key],
                'distributor_price' => $distributor_price[$key],
                'stok' =>$stok[$key]
            ]);
        }

        // Redirect atau berikan respons sesuai kebutuhan Anda
        return back()->with('success', 'Produk berhasil ditambahkan!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)

    {
        Product::where('id',$id)->delete();
        return back()->with('success','successfully deleted product');
    }
    // public function view_export($id, Request $request)
    // {
    //     $baseUrl = config('app.api_base_url');
    //     $apiToken = config('app.api_token');

    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . $apiToken,
    //         'Accept' => 'application/json',
    //     ])->get($baseUrl . '/inventory/items/');
    //     $product = $response->json();
    //     $data['product'] = $product['data'];
    //     $filter = collect($data['product'])->where('item_group_id', '=', $id);
    //     $filters = json_decode($filter);
    //     foreach ($filters as $item) {
    //         $filterss[] = $item;
    //     }
    //     foreach ($filterss[0]->variants as $key => $products) {
    //         foreach ($products->variation_values as $key => $value) {
    //             $colors[] = $value;
    //         }
    //     }
    //         $color = [];
    //         $currentGroup = [];
    //         foreach ($colors as $item) {
    //             if ($item->label == "Warna") {
    //                 $currentGroup["Warna"] = $item->value;
    //             } elseif ($item->label == "Ukuran") {
    //                 $currentGroup["Ukuran"] = $item->value;
    //                 $color[] = $currentGroup;
    //                 $currentGroup = [];
    //             }
    //         }
    //         $form = [];
    //         foreach ($color as $key => $variations) {
    //             $form[] = [
    //                 'warna'=>$variations['Warna'],
    //                 'ukuran'=>$variations['Ukuran']
    //             ];
    //         }
    //         // dd($form);
    //         $data['form'] = $form;
    //         return view('export',$data);
    // }
    // public function export($id, Request $request)
    // {
    //     $baseUrl = config('app.api_base_url');
    //     $apiToken = config('app.api_token');

    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . $apiToken,
    //         'Accept' => 'application/json',
    //     ])->get($baseUrl . '/inventory/items/');
    //     $product = $response->json();
    //     $data['product'] = $product['data'];
    //     $filter = collect($data['product'])->where('item_group_id', '=', $id);
    //     $filters = json_decode($filter);
    //     foreach ($filters as $item) {
    //         $filterss[] = $item;
    //     }
    //     $images = [
    //         'slug'=>Str::random(20),
    //         'path'=>$filterss[0]->thumbnail
    //     ];
    //     $category = Category::find($request->category);
    //     $brand = Merk::find($request->brand);

    //     $product = new Product();
    //     $product->item_group_name = $filterss[0]->item_name;
    //     $product->description = $request->description;
    //     $product->spesifikasi = $request->sepesifikasi;
    //     $product->sell_this = true;
    //     $product->reseller_sell_price = $filterss[0]->sell_price;
    //     $product->buy_this = true;
    //     $product->stock_this = true;
    //     $product->sell_price = $filterss[0]->sell_price;
    //     $product->item_category_id =$category->id;
    //     $product->category_name =$category->name;
    //     $product->images = $images;
    //     $product->brand_id = $brand->id; // Ganti dengan nilai yang sesuai
    //     $product->recomendation = $request->has('recomendation'); // Ganti dengan nilai yang sesuai
    //     $product->is_active = false; // Ganti dengan nilai yang sesuai
    //     $product->export = true; // Ganti dengan nilai yang sesuai
    //     $product->package_content = null; // Ganti dengan nilai yang sesuai
    //     $product->package_weight = 1; // Ganti dengan nilai yang sesuai
    //     $product->package_height =1; // Ganti dengan nilai yang sesuai
    //     $product->package_width = 1; // Ganti dengan nilai yang sesuai
    //     $product->package_length = 1; // Ganti dengan nilai yang sesuai
    //     $product->brand_name = $brand->name; // Ganti dengan nilai yang sesuai
    //     // Simpan ke database
    //     $product->save();
    //     foreach ($filterss[0]->variants as $key => $products) {
    //         foreach ($products->variation_values as $key => $value) {
    //             $colors[] = $value;
    //         }
    //     }
    //         $color = [];
    //         $currentGroup = [];
    //         foreach ($colors as $item) {
    //             if ($item->label == "Warna") {
    //                 $currentGroup["Warna"] = $item->value;
    //             } elseif ($item->label == "Ukuran") {
    //                 $currentGroup["Ukuran"] = $item->value;
    //                 $color[] = $currentGroup;
    //                 $currentGroup = [];
    //             }
    //         }
    //         foreach ($color as $key => $variations) {
    //             Variations::create([
    //                 'slug' => Str::random(10),
    //                 'product_id' => $product->id,
    //                 'sku' => $products->barcode,
    //                 'warna' => $variations['Warna'],
    //                 'size' =>$variations['Ukuran'],
    //                 'price' => $products->sell_price,
    //                 'reseller_price' => $products->sell_price,
    //                 'stok' =>100
    //             ]);
    //         }
    //         return back()->with('succcess','successfully Export product');
    // }
}
