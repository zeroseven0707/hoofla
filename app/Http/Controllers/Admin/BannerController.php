<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $data['banners'] = Banner::all();
        $data['product'] = Product::all();
        return view('banner',$data);
    }


    public function store(Request $request)
    {

        // Mengambil file gambar dari permintaan
        if($request->type == 1){
            $image = $request->file('image');
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|unique:banners'
            ]);
            $product = Product::where('id',$request->product_id)->first();
            $category = Category::where('id',$product->item_category_id)->first();
            $type = $request->type;
            $text_1 = $category->name;
            $text_2 = $product->item_group_name;
            $text_3 = $product->sell_price;
            $link = "http://127.0.0.1:8000/product/".$product->id;

        }else{
            $image = $request->file('image');
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|unique:banners',
                'link' => 'required|max:255|unique:banners'
            ]);
            $type = $request->type;
            $text_1 ="";
            $text_2 ="";
            $text_3 ="";
            $link = $request->link;
        }

        // Menyimpan data banner ke database
        Banner::create([
            'type' => $type,
            'text_1' => $text_1,
            'text_2' => $text_2,
            'text_3' => $text_3,
            'image' => $image->store('banner'),
            'link' => $link,
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully.');
}


    public function update(Request $request, Banner $banner)
    {
        if($banner->type == 1){
            $product = Product::where('id',$request->product_id)->first();
            $category = Category::where('id',$product->item_category_id)->first();
            $text_1 = $category->name;
            $text_2 = $product->item_group_name;
            $text_3 = $product->sell_price;
            $link = "http://127.0.0.1:8000/product/".$product->id;

        }else{
            $text_1 ="";
            $text_2 ="";
            $text_3 ="";
            $link = $request->link;
        }

        // Mengambil file gambar yang baru dari permintaan
        $newImage = $request->file('image');

        // Memeriksa apakah ada file gambar baru yang diunggah
        if ($newImage) {
            $banner->image = $newImage->store('banner');
        }

        // Memperbarui atribut lainnya
        $banner->link = $link;
        $banner->text_1 = $text_1;
        $banner->text_2 = $text_2;
        $banner->text_3 = $text_3;

        // Menyimpan perubahan pada model
        $banner->save();

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
    }
}
