<?php
 
namespace App\Http\Controllers;
use App\Models\User;
 
use Illuminate\Http\Request;
 
class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.petugas', compact('users'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'nama_petugas' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        User::create([
            'username' => $request->username,
            'nama_petugas' => $request->nama_petugas,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role ?? 'petugas',
        ]);
 
        return redirect('/admin/petugas')->with('success', 'Petugas berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'username' => 'required',
            'nama_petugas' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
 
        $user = User::where('id', $id)->first();
        // Update data user
        $user->update([
            'username' => $request->username,
            'nama_petugas' => $request->nama_petugas,
            'email' => $request->email,
            'password' => $request->password,
        ]);
 
         return redirect('/admin/petugas')->with('success', 'Petugas berhasil diupdate');
    }
 
    public function destroy(Request $request)
    {
        $petugas = User::findOrFail($request->id);
        $petugas->delete();
 
         return redirect('/admin/petugas')->with('success', 'Data berhasil dihapus');
    }
}
 
