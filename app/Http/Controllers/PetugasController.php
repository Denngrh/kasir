<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $barangs = Barang::all();
        $members = Member::all();
        $urutan = rand(1, 999);
        $penjualans = Penjualan::dataPenjualan();
        $penjualan = Penjualan::get();
        $totalHarga = $penjualan->sum('total');

        $huruf = "AD";
        $tgl = date("jnyGi");

        $noNota = $huruf . $tgl . sprintf("%03s", $urutan);
        return view('petugas.dashboard')->with(['noNota' => $noNota, 'barangs' => $barangs, 'members' => $members, 'penjualans' => $penjualans, 'totalHarga' => $totalHarga]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_member' => 'required',
            'email' => 'required',
            'nomer_hp' => 'required',
            'alamat' => 'required',
        ]);
        DB::beginTransaction();
        Member::create([
            'nama_member' => $request->nama_member,
            'email' => $request->email,
            'nomer_hp' => $request->nomer_hp,
            'alamat' => $request->alamat,
            'diskon' => $request->diskon ?? 0,
        ]);
        DB::commit();
        return redirect('/petugas/dashboard')->with('success', 'Member berhasil ditambahkan');
    }
    public function cari_barang(Request $request)
    {
        if (!empty($request->query('cari_barang'))) {
            $selectedBarangs = $request->input('selectedBarangs');
            $hasil1 = Barang::whereIn('id', $selectedBarangs)->get();
            return view('petugas.hasil_cari', compact('hasil1'));
        }
    }
    public function ambil_barang(Request $request)
    {
        if (!empty($request->query('ambil_barang'))) {
            $selectedBarangs = $request->input('selectedBarangs');
            $hasil1 = Barang::whereIn('id', $selectedBarangs)->get();
            return view('petugas.ambil_barang', compact('hasil1'));
        }
    }
    public function jual(Request $request)
    {
        if (!empty($request->query('jual'))) {
            $id = $request->query('id');

            $barang = Barang::where('kode_barang', $id)->first();
            if ($barang->stok > 0) {
                $jumlah = 1;
                $total = $barang->harga;

                Penjualan::tambahPenjualan($id, $jumlah, $total);

                return redirect('/petugas/dashboard');
            } else {
                return redirect('/petugas/dashboard')->with('message', 'Stok Barang Anda Telah Habis !');
            }
        }
    }
    public function updateHarga(Request $request)
    {
        $penjualan = Penjualan::find($request->penjualan_id);

        if (!$penjualan) {
            return response()->json(['error' => 'Penjualan tidak ditemukan'], 404);
        }

        $penjualan->jumlah = $request->jumlah;
        $penjualan->total = $request->jumlah * $penjualan->harga; // Misalnya harga ada dalam tabel Penjualan
        $penjualan->save();

        $totalHarga = Penjualan::sum('total');

        return response()->json(
            [
                'success' => true,
                'penjualan' => $penjualan, // Mengirim objek penjualan yang telah diperbarui
                'totalHarga' => $totalHarga,
            ],
            200,
        );
    }
    public function destroy(Request $request)
    {
        $penjualan = Penjualan::findOrFail($request->id);
        $penjualan->delete();

         return redirect('/petugas/dashboard')->with('success', 'Data berhasil di hapus');
    }

    public function tambahData(Request $request) {
        $this->validate($request, [
            'noNota' => 'required',
            'rfc' => 'required',
            'diskon' => 'required',
            'jml' => 'required',
            'total' => 'required',
            'bayar' => 'required',
            'kembalian' => 'required',
        ]);
        DB::beginTransaction();
        Member::create([
            'noNota' => $request->no_nota,
            'rfc' => $request->id_member,
            'diskon' => $request->diskon,
            'jml' => $request->jumlah,
            'total' => $request->subtotal,
            'bayar' => $request->bayar,
            'kembalian' => $request->kembalian,
        ]);
        DB::commit();
        return redirect('/petugas/dashboard')->with('success', 'Member berhasil ditambahkan');
    }
    }
