<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail extends Model
{
    protected $table='detail_penjualan';
    protected $fillable=['penjualan_id','produk_id','jumlahProduk','subTotal'];
}
