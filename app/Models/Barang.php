<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Barang extends Model
{
    protected $fillable = ['kode_barang', 'nama_barang', 'stok', 'harga'];

    public static function cariBarang($cari)
    {
        return DB::table('barangs')
        ->select('barangs.*')
        ->where('barangs.kode_barang', 'like', '%' . $cari . '%')
        ->orWhere('barangs.nama_barang', 'like', '%' . $cari . '%')
        ->get();
    }
}
 