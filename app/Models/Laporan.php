<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = ['no_nota', 'nama_kasir', 'produk', 'nama_member','diskon', 'qty', 'subtotal', 'bayar', 'kembalian'];
}
