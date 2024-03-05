<?php

namespace App\Http\Controllers\web;
use App\Models\baco;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class homeController extends Controller
{
    // public function show()
    // {
    //     return Inertia::render('Belajar');
    // }
    // public function simpan(Request $request)
    // {
    //     $gambar=$request->file('gambar')->store('gambar', 'public');
    //     baco::updateOrCreate(['id'=>$request->id],[
    //         'judul'=>$request->judul,
    //         'isi'=>$request->isi,
    //         'gambar'=>$gambar
    //     ]);
    //     return back();
        
    // }

    // public function tampil(){

    //     $data=baco::get();
    //     return response()->json($data);
    // }

    // public function edit($id){
    //     $data=baco::where('id', $id)->first();
    //     return response()->json($data);
    // }

    // public function hapus($id)
    // {
    //     baco::destroy($id);
    //     return Inertia::render('Belajar');
    // }

}