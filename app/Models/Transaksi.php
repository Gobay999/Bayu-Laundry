<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'user_id',
        'nama_pelanggan',
        'alamat',
        'jenis_layanan',
        'berat_atau_jumlah',
        'total_harga',
        'metode_pembayaran',
        'status_pembayaran'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}