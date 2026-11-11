<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Rating;

class TransaksiController extends Controller
{
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/pelanggan');
        }

        $data_transaksi = Transaksi::orderBy('id', 'desc')->get();
        $data_pelanggan = User::where('role', 'pelanggan')->orderBy('id', 'desc')->get();
        $data_rating = Rating::with('user')->orderBy('id', 'desc')->get();
        
        return response()->view('kasir_admin', compact('data_transaksi', 'data_pelanggan', 'data_rating'))
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    public function dashboardPelanggan()
    {
        if (Auth::user()->role === 'admin') {
            return redirect('/kasir');
        }

        $data_transaksi = Transaksi::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        $data_rating = Rating::with('user')->orderBy('id', 'desc')->get(); 
        
        return response()->view('pelanggan', compact('data_transaksi', 'data_rating'))
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
            'jenis_layanan' => 'required|string',
            'metode_pembayaran' => 'required|string',
        ]);

        Transaksi::create([
            'user_id' => Auth::id(),
            'nama_pelanggan' => Auth::user()->name,
            'alamat' => $request->alamat,
            'jenis_layanan' => $request->jenis_layanan,
            'berat_atau_jumlah' => 0, 
            'total_harga' => 0, 
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'Menunggu Ditimbang'
        ]);

        return redirect('/pelanggan')->with('success', 'Pesanan berhasil dikirim! Kurir kami akan segera menjemput cucian Anda.');
    }

    public function updateTimbang(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $berat = $request->berat;
        $harga_satuan = 0;

        if ($transaksi->jenis_layanan == 'Cuci/Gosok Saja') $harga_satuan = 5000 * $berat;
        elseif ($transaksi->jenis_layanan == 'Cuci + Gosok') $harga_satuan = 7000 * $berat;
        elseif ($transaksi->jenis_layanan == 'Bed Cover - Single (Kecil)') $harga_satuan = 15000 * $berat;
        elseif ($transaksi->jenis_layanan == 'Bed Cover - Queen (Sedang)') $harga_satuan = 20000 * $berat;
        elseif ($transaksi->jenis_layanan == 'Bed Cover - King (Besar)') $harga_satuan = 30000 * $berat;
        elseif ($transaksi->jenis_layanan == 'Karpet - Small (Kecil)') $harga_satuan = 40000 * $berat;
        elseif ($transaksi->jenis_layanan == 'Karpet - Medium (Sedang)') $harga_satuan = 60000 * $berat;
        elseif ($transaksi->jenis_layanan == 'Karpet - Large (Besar)') $harga_satuan = 75000 * $berat;

        $transaksi->update([
            'berat_atau_jumlah' => $berat,
            'total_harga' => $harga_satuan,
            'status_pembayaran' => 'Sedang Diproses'
        ]);

        return redirect('/kasir')->with('success', 'Berat/Jumlah berhasil diinput dan total tagihan diperbarui!');
    }

    public function updateStatus($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update(['status_pembayaran' => 'Selesai & Lunas']);
        return redirect('/kasir')->with('success', 'Pesanan selesai dan pembayaran dilunasi!');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return redirect('/kasir')->with('success', 'Data transaksi berhasil dihapus!');
    }

    public function cetakStruk($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('struk', compact('transaksi'));
    }

    private function filterUlasan($teks)
    {
        if (empty($teks)) return $teks;

        $kataSensor = [
            'anjing', 'babi', 'kontol', 'memek', 'asu', 'fuck', 'shit', 'bitch', 'asshole', 'bastard',
            'slot', 'gacor', 'maxwin', 'depo', 'wd', 'mahjong', 'pragmatic', 'olympus', 
            'scatter', 'situs resmi', 'link alternatif', 'bonus harian', 'freechip', 
            'rtp tertinggi', 'jackpot', 'bet 200', 'bet perak', 'casino', 'poker online'
        ];

        $teksBersih = $teks;

        foreach ($kataSensor as $kata) {
            // Menggunakan preg_replace yang benar dengan modifier /i (insensitive)
            $teksBersih = preg_replace('/\b' . preg_quote($kata, '/') . '\b/i', '***', $teksBersih);
            $teksBersih = str_ireplace($kata, '***', $teksBersih);
        }

        return $teksBersih;
    }

    public function storeRating(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:500'
        ]);

        $ulasanAman = $this->filterUlasan($request->ulasan);

        Rating::create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'ulasan' => $ulasanAman
        ]);

        return redirect('/pelanggan')->with('success', 'Terima kasih! Penilaian Anda berhasil dipublikasikan di Forum Ulasan.');
    }

    public function balasRating(Request $request, $id)
    {
        $rating = Rating::findOrFail($id);
        $ulasanAman = $this->filterUlasan($request->ulasan);

        $rating->update([
            'ulasan' => $ulasanAman, 
            'balasan_admin' => $request->balasan_admin
        ]);

        return redirect('/kasir')->with('success', 'Ulasan berhasil direspon & dimoderasi!');
    }

    public function hapusRating($id)
    {
        Rating::findOrFail($id)->delete();
        return redirect('/kasir')->with('success', 'Ulasan pelanggan berhasil dihapus dari forum!');
    }
}