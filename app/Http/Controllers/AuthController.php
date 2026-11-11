<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Transaksi;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (Auth::user()->email === 'admin@laundry.com' || Auth::user()->name === 'Admin Laundry') {
                User::find(Auth::id())->update(['role' => 'admin']);
                return redirect()->intended('/kasir');
            } 
            
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/kasir');
            } else {
                return redirect()->intended('/pelanggan');
            }
        }

        return back()->with('error', 'Email atau Password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function register()
    {
        return view('register');
    }

    public function storeRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan'
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // --- HALAMAN & LOGIKA LUPA PASSWORD ---
    public function lupaPassword()
    {
        return view('lupa_password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed' // atau password baru
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }

    // --- HALAMAN & LOGIKA LUPA EMAIL ---
    public function lupaEmail()
    {
        return view('lupa_email');
    }

    public function cariEmail(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $user = User::where('name', 'LIKE', '%' . $request->name . '%')->first();

        if ($user) {
            return back()->with('success', 'Akun ditemukan! Email yang terdaftar untuk nama tersebut adalah: ' . $user->email);
        }

        return back()->with('error', 'Maaf, nama tersebut tidak ditemukan di sistem.');
    }

    // -- FITUR ADMIN: UBAH PROFIL SENDIRI --
    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6'
        ]);

        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('/kasir')->with('success', 'Profil dan Kredensial Admin berhasil diperbarui!');
    }

    // -- FITUR ADMIN: EDIT PELANGGAN --
    public function updatePelanggan(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect('/kasir')->with('success', 'Data akun pelanggan berhasil diperbarui!');
    }

    // -- FITUR ADMIN: HAPUS PELANGGAN --
    public function destroyPelanggan($id)
    {
        $user = User::findOrFail($id);
        Transaksi::where('user_id', $id)->delete();
        $user->delete();

        return redirect('/kasir')->with('success', 'Akun pelanggan beserta seluruh riwayat transaksinya berhasil dihapus!');
    }
}