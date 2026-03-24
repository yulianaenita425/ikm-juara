<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function settings()
    {
        $admins = User::all();
        return view('admin.pengaturan', compact('admins'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return back()->with('success', 'Admin baru berhasil ditambahkan!');
    }

    public function deleteAdmin($id)
    {
        if (User::count() <= 1) {
            return back()->with('error', 'Tidak bisa menghapus admin terakhir!');
        }
        
        User::find($id)->delete();
        return back()->with('success', 'Admin berhasil dihapus!');
    }
}