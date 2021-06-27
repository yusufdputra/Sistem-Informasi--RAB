<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Kelola Data Pimpinan";
        $users = User::with('roles')->get();
        $pimpinan = $users->reject(function ($admin, $key) {
            return $admin->hasRole('admin');
        });

        return view('admin.users.index', compact('pimpinan', 'title'));
    }

    public function store(Request $request)
    {

        // validasi apakah email sudah terdaftar atau belum
        $query = User::where('email',  $request->input('email'));
        if ($query->exists()) { //jika ada
            return redirect()->back()->with('alert', 'Email Sudah terdaftar');
        } else { // jika belum 


            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password),

            ]);

            $user->assignRole('pimpinan');
            return redirect()->back()->with('success', 'Pengguna berhasil terdaftar');
        }
    }

    public function edit($id)
    {
        return User::find($id);
    }

    public function update(Request $request)
    {
        if ($request->email != $request->old_email) {
            $request->validate([
                'email' => 'required|unique:users|max:255',
            ]);
        }
        
            User::where('id', $request->id)
                ->update([
                    'name' => $request->nama,
                    'email' => $request->email,

                ]);

            return redirect()->back()->with('success', 'Data berhasil diubah');
        
    }

    public function hapus(Request $request)
    {

        $query = User::where('id', $request->id)
            ->delete();

        if ($query) {
            return redirect()->back()->with('success', 'Berhasil menghapus pimpinan');
        } else {
            return redirect()->back()->with('alert', 'Gagal menghapus pimpinan');
        }
    }

    public function resetpw(Request $request)
    {
        $query = User::where('id', $request->id)
            ->update([
                'password' => bcrypt($request->password)
            ]);

        if ($query) {
            return redirect()->back()->with('success', 'Password User berhasil diubah');
        } else {
            return redirect()->back()->with('alert', 'Password User gagal diubah');
        }
    }
}
