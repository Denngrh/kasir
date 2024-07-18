<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;

 
 
class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        $total_barang = Barang::count();
        $count = 'BRG' . str_pad($total_barang + 1, 3, '0', STR_PAD_LEFT);
        if ($total_barang === 0) {
            $count = 'BRG001';
        }
        return view('admin/barang', compact('count', 'barangs'));
    }
 
    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'stok' => 'required',
            'harga' => 'required',
        ]);
        Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'stok' => $request->stok,
            'harga' => $request->harga,
        ]);
 
        return redirect('/admin/barang')->with('success', 'Data berhasil di tambahkan');
 
    }
 
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_barang' => 'required',
            'stok' => 'required',
            'harga' => 'required',
        ]);
        
        $barang = Barang::where('id', $id)->first();
        // Update data barang
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'stok' => $request->stok,
            'harga' => $request->harga,
        ]);
 
         return redirect('/admin/barang')->with('success', 'Data berhasil di update');
    }
 
    public function destroy(Request $request)
    {
        $barang = Barang::findOrFail($request->id);
        $barang->delete();
 
         return redirect('/admin/barang')->with('success', 'Data berhasil di hapus');
    }
    public function export()
    {
        $barangs = Barang::orderBy('created_at', 'asc')->get();

        return response()->json($barangs);
    }
    public function cetak_pdf()
    {
        $barangs = Barang::all();
        $pdf = PDF::loadview('admin.barang.cetak_pdf', ['barangs' => $barangs]);
        return $pdf->download('laporan_barang.pdf');

    }
}