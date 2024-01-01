<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('banner', compact('banners'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|unique:banners',
            'link' => 'required|max:255|unique:banners'
        ]);

        // Mengambil file gambar dari permintaan
        $image = $request->file('image');

        // Menyimpan data banner ke database
        Banner::create([
            'type' => $request->type,
            'text_1' => $request->text_1,
            'text_2' => $request->text_2,
            'text_3' => $request->text_3,
            'image' => $image->store('banner'),
            'link' => $request->input('link'),
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully.');
}


    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'link' => 'required',
        ]);

        // Mengambil file gambar yang baru dari permintaan
        $newImage = $request->file('image');

        // Memeriksa apakah ada file gambar baru yang diunggah
        if ($newImage) {
            // // Menghapus gambar lama dari penyimpanan
            // Storage::delete("public/banner/{$banner->image}");

            // // Menyimpan gambar baru di penyimpanan
            // $newImagePath = $newImage->storeAs('public/banner', $newImage->getClientOriginalName());

            // // Mendapatkan nama file gambar baru
            // $newImageName = basename($newImagePath);


            // Mengganti nama file gambar di model dengan yang baru
            $banner->image = $newImage->store('banner');
        }

        // Memperbarui atribut lainnya
        $banner->link = $request->input('link');
        $banner->type = $request->input('type');
        $banner->text_1 = $request->input('text_1');
        $banner->text_2 = $request->input('text_2');
        $banner->text_3 = $request->input('text_3');

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
