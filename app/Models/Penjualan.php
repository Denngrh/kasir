<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function tambahPenjualan($id, $jumlah, $total)
    {
        $penjualan = Penjualan::where('kode_barang', $id)->first();
        if ($penjualan) {
            $penjualan->jumlah += $jumlah;
            $penjualan->total += $total;
            $penjualan->save();
        } else {
            Penjualan::create([
                'kode_barang' => $id,
                'harga' => $total,
                'jumlah' => $jumlah,
                'total' => $total,
            ]);
        }
    }

    public static function dataPenjualan()
    {
        return DB::table('penjualans')
        ->select('penjualans.*', 'barangs.kode_barang', 'barangs.nama_barang', 'barangs.stok')
        ->leftJoin('barangs', 'barangs.kode_barang', '=', 'penjualans.kode_barang')
        ->orderBy('penjualans.id')
        ->get();
    }
}
