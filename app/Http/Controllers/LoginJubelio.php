<?php

namespace App\Http\Controllers;

use App\Models\JubelioToken;
use App\Models\Product;
use App\Models\Variations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginJubelio extends Controller
{
    public static function login()
    {
        $http = new \GuzzleHttp\Client();
        $jubelio = $http->post('https://api2.jubelio.com/login',[
            'json'=> [
                "email"=> "hooflatest01@gmail.com",
                "password"=> "Hoofla123!"
            ]
        ]);
        $jube = json_decode((string)$jubelio->getBody(), true);
        JubelioToken::where('id',1)->update([
            'token'=>$jube['token']
        ]);
    }
    public static function search(Request $request)
    {
        $cari = $request->search;
        $data['product'] = Product::where('item_group_name', 'like', '%' . $cari . '%')->where('is_active',1)->get();
        return view('customer.search', $data);
    }
    public function cekstok($id, Request $request)
    {
        try {
            $data = Variations::where('id', $id)->first();
            $stok = $data->stok;

            return response()->json(['stok' => $stok]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function searchProducts(Request $request)
    {
        try {
            $category = $request->input('category');
            $sort = $request->input('sort');

            // Mulai dengan query dasar
            $query = DB::table('products')->where('is_active', 1);

            // Filter by category
            if ($category) {
                $query->where('item_category_id', $category);
            }

            // Sort by options
            if ($sort == 'sell_price') {
                $query->orderBy('sell_price', 'asc');
            } elseif ($sort == 'asc') {
                $query->orderBy('item_group_name', 'asc');
            } elseif ($sort == 'desc') {
                $query->orderBy('item_group_name', 'desc');
            }

            // Ambil hasil query
            $products = $query->get();

            // Debugging: Cetak hasil query
            dd($products);

            // Kembalikan hasil dalam bentuk JSON
            return response()->json(['products' => $products]);
        } catch (\Exception $e) {
            // Tangani kesalahan
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
public function page_category($id){
    $data['product'] = Product::where('item_category_id',$id)->where('is_active',1)->get();
    return view('customer.category-page',$data);
}
}
