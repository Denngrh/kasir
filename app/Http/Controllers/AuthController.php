<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\LoginLog;
 
class AuthController extends Controller
{
public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
        // Simpan log login
        $this->saveLoginLog(Auth::user()->username, Auth::user()->nama_petugas, 'login');
 
            Session::put('nama_petugas', Auth::user()->nama_petugas);
 
            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                    break;
                case 'petugas':
                    return redirect()->route('petugas.dashboard');
                    break;
                default:
                    return redirect('/')->with('alert', 'Invalid role');
            }
        }
 
        return redirect('/')->with('alert', 'Username Dan Password Salah!!');
    }
 
    public function logout()
    {
        // Simpan log logout
        $this->saveLoginLog(Auth::user()->username, Auth::user()->nama_petugas, 'logout');
 
        Session::flush();
        return redirect('/')->with('alert','Anda telah logout');
    }
 
    private function saveLoginLog($username, $namaPetugas, $keterangan)
    {
        $loginLog = new LoginLog();
        $loginLog->username = $username;
        $loginLog->nama_petugas = $namaPetugas;
        $loginLog->waktu = now();
        $loginLog->keterangan = $keterangan;
        $loginLog->save();
    }
 
}