<?php

namespace App\Http\Controllers;
use App\Models\detail;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\produk;
use App\Models\pelanggan;
use App\Models\penjualan;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class kasirController extends Controller
{
    public function index(){
        return Inertia::render('barang');
    }

    public function barangTampil()
    {
        $data = produk::latest()->get();
        return response()->json($data);
    }

    public function barangPost(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required',
            'stok' => 'required',
        ]);
        produk::updateOrCreate(['id' => $request->id],[
            'namaProduk' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok
        ]);
        return back();
}

public function barangEdit($id){
    $data=produk::where('id',$id)->first();
    return response()->json($data);
}
public function barangHapus($id){
    produk::where('id', $id)->delete();
    return back();
}

//DATA PELaNGGAN
public function pelanggan(){
    return Inertia::render('pelanggan');
}

public function pelangganTampil()
{
    $data = pelanggan::latest()->get();
    return response()->json($data);
}

public function pelangganPost(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'alamat' => 'required',
        'noTelp' => 'required',
    ]);
    pelanggan::updateOrCreate(['id' => $request->id],[
        'namaPelanggan' => $request->nama,
        'alamat' => $request->alamat,
        'nomorTelpon' => $request->noTelp
    ]);
    return back();
}

public function pelangganEdit($id){
$data=pelanggan::where('id',$id)->first();
return response()->json($data);
}
public function pelangganHapus($id){
pelanggan::where('id', $id)->delete();
return back();
}

//Penjualan 
public function penjualan()
    {
        return Inertia::render('penjualan');
    }
    public function cariPelanggan(Request $request)
    {
        $cari=$request->get('cari');
        $data=pelanggan::
        where('id','like','%'.$cari.'%')
        ->orWhere('namaPelanggan','like','%'.$cari.'%')
        ->first();
        return response()->json($data);
    }
    public function setBarang()
    {
        $data=produk::latest()->get();
        return response()->json($data);
    }
    public function simpanProduk(Request $request)
    {
        $tgl=Carbon::now();
        $produk = produk::find($request->produk_id);
        $stokTersedia = $produk->stok;

        if ($request->jumlah > $stokTersedia) {
            return back()->withErrors(['jumlah' => 'Jumlah produk melebihi stok tersedia']);
        }
    
        $penjualan=penjualan::create([
            'tanggalPenjualan'=>$tgl,
            'pelanggan_id'=>$request->pelanggan_id,
            'totalHarga'=>$request->total
        ]);

        detail::create([
            'penjualan_id'=>$penjualan->id,
            'produk_id'=>$request->produk_id,
            'jumlahProduk'=>$request->jumlah,
            'subTotal'=>$request->subTotal
        ]);

        $produk->stok -= $request->jumlah;
        $produk->save();
        return back();
    }

    public function detailProduk($id)
    {   
       
        $data=DB::table('penjualan as pen')
            ->leftJoin('detail_penjualan as dp','pen.id','=','dp.penjualan_id')
            ->leftJoin('produk as pro','dp.produk_id','=','pro.id')
            ->select('pen.*','dp.jumlahProduk','dp.subTotal','pro.namaProduk','pro.harga')
            ->where('pen.pelanggan_id', $id)
            ->whereDate('pen.tanggalPenjualan',Carbon::today())
            ->get();
        return response()->json($data);
    }
    public function updateSubTotal($subtotal, $id)
    {
        detail::where('penjualan_id', $id)->update([
            'subTotal'=>$subtotal
        ]);
        return response()->json($id);
    }

    public function hapusList($id){
        penjualan::where('id', $id)->delete();
        return back();
        }
        public function editList($id){
        $data=detail::where('id',$id)->first();
            return response()->json($data);
        }
        public function info(){
            $tobar=produk::count();
            $jupel=pelanggan::count();
            $tomas=detail::get();
            $petugas = User::where('role','petugas')->count();
            return response()->json([
                'tobar'=>$tobar,
                'jupel'=>$jupel,
                'tomas'=>$tomas,
                'topa' =>$petugas
            ]);
        }
}
