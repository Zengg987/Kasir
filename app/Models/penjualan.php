<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    protected $table='penjualan';
    protected $fillable=['tanggalPenjualan','totalHarga','pelanggan_id'];
}
