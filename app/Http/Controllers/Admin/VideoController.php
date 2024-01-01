<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return view('video', compact('videos'));
    }


    public function store(Request $request)
    {
        // Menyimpan data banner ke database
        $video_1 = Video::where('number',1)->first();
        $video_2 = Video::where('number',2)->first();
        if ($request->link_satu) {
            # code...
            if ($video_1 == null) {
                Video::create([
                    'link' => $request->link_satu,
                    'number'=>1
                ]);
            }else{
                Video::where('number',1)->update([
                    'link' => $request->input('link_satu'),
                ]);
            }
        }else{
            if ($video_2 == null) {
                Video::create([
                    'link' => $request->input('link_dua'),
                    'number'=>2
                ]);
            }else{
                Video::where('number',2)->update([
                    'link' => $request->input('link_dua'),
                ]);
            }
        }
        return redirect()->route('videos.index')->with('success', 'Banner created successfully.');
}


    public function update(Request $request, Video $video)
    {
        $request->validate([
            'link' => 'required',
        ]);
        $video->update($request->all());

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
    }
}
