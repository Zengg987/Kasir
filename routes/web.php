<?php

use App\Http\Controllers\web\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\kasirController;
use GuzzleHttp\Middleware;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

/*
|-----------------------------------------------------------------      ---------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [loginController::class, 'show'])->name('login');
Route::post('/login', [loginController::class, 'login']);
Route::get('/logout', [loginController::class, 'logout']);

//Admin
route::middleware(['auth', 'role:admin'])->group(function () {
    route::get('/admin', [adminController::class, 'index']);
    //agar admin bisa tambah user atau register user 
    route::get('/addUser', [adminController::class, 'addUser']);
    Route::post('/addUser', [adminController::class, 'postUser']);
    Route::get('/userGet', [adminController::class, 'getUser']);
    Route::get('/addUser/edit/{id}', [adminController::class, 'editUser']);
    Route::get('/addUser/delete/{id}', [adminController::class, 'hapusUser']);
    Route::get('/info',[kasirController::class,'info']);
});

//user dan admin
Route::middleware(['auth', 'role:petugas|admin',])->group(function(){
    Route::get('/petugas',[adminController::class,'index']);

    //barang
    Route::get('/barang',[kasirController::class,'index']);
    Route::get('/barang/tampil',[kasirController::class,'barangTampil']);
    Route::post('/barang/tambah',[kasirController::class,'barangPost']);
    Route::get('/barang/edit/{id}',[kasirController::class,'barangEdit']);
    Route::get('/barang/hapus/{id}',[kasirController::class,'barangHapus']);
    
    //pelanggan
    Route::get('/pelanggan',[kasirController::class,'pelanggan']);
    Route::get('/pelanggan/view',[kasirController::class,'pelangganTampil']);
    Route::post('/pelanggan/tambah',[kasirController::class,'pelangganPost']);
    Route::get('/pelanggan/edit{id}',[kasirController::class,'pelangganEdit']);
    Route::get('/pelanggan/hapus{id}',[kasirController::class,'pelangganHapus']);

    //penjualan
    Route::get('/penjualan',[kasirController::class,'penjualan']);
    Route::get('/caripelanggan',[kasirController::class,'cariPelanggan']);
    Route::get('/setbarang',[kasirController::class,'setBarang']);
    Route::post('/produkSimpan',[kasirController::class,'simpanProduk']);
    Route::get('/detailproduk/{id}',[kasirController::class,'detailProduk']);
    Route::get('/updatetotal/{id}',[kasirController::class,'updateTotal']);
    Route::get('/subtotalUpdate/{subtotal}/{id}',[kasirController::class,'updateSubTotal']);
    Route::get('/hapusList/{id}',[kasirController::class,'hapusList']);
    Route::get('/editList/{id}',[kasirController::class,'editList']);

   //Dashboard
   Route::get('/info',[kasirController::class,'info']); 

});