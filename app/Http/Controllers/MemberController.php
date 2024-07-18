<?php
 
namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Http\Request;
 
class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('admin.member', compact('members'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_member' => 'required',
            'email' => 'required',
            'nomer_hp' => 'required',
            'alamat' => 'required',
        ]);
        Member::create([
            'nama_member' => $request->nama_member,
            'email' => $request->email,
            'nomer_hp' => $request->nomer_hp,
            'alamat' => $request->alamat,
            'diskon' => $request->diskon ?? 0,
        ]);
 
        return redirect('/admin/member')->with('success', 'Member berhasil ditambahkan');
    }
 
    public function update(Request $request)
    {
        $this->validate($request, [
            'nama_member' => 'required',
            'email' => 'required',
            'nomer_hp' => 'required',
            'alamat' => 'required',
            'diskon' => 'required',
        ]);
 
        $member = Member::where('id_member', $request->id_member)->update([
            'nama_member' => $request->nama_member,
            'email' => $request->email,
            'nomer_hp' => $request->nomer_hp,
            'alamat' => $request->alamat,
            'diskon' => $request->diskon,
        ]);
 
        return redirect('/admin/member')->with('success', 'Data berhasil di update');
    }
    public function destroy(Request $request)
    {
        $member = Member::where('id_member', $request->id_member)->delete();
 
        return redirect('/admin/barang')->with('success', 'Data berhasil di hapus');
    }
    public function updateDiskon()
    {
        $membersToUpdate = Member::where('diskon', 0)->get();
        // dd($membersToUpdate);
        foreach ($membersToUpdate as $member) {
            $member->diskon = 5;
            $member->save();
        }
 
        return redirect('/admin/member')->with('success', 'Diskon berhasil diupdate');
    }
}
 