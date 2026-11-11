<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - Laundry Bayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .star-rating { direction: rtl; display: inline-flex; }
        .star-rating input { display: none; }
        .star-rating label {
            color: #e4e5e9; font-size: 2.5rem; padding: 0 5px; cursor: pointer; transition: color 0.2s;
        }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label { color: #ffc107; }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100" style="background-color: #f4f6f9 !important;">
    <div class="container mt-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-md-9">
                
                <!-- Form Pesanan -->
                <div class="card shadow-sm mb-4 border-0 rounded-3">
                    <div class="card-header bg-success bg-gradient text-white d-flex justify-content-between align-items-center py-3">
                        <h4 class="mb-0"><i class="fa-solid fa-hand-sparkles me-2"></i>Halo, {{ Auth::user()->name }}</h4>
                        <a href="/logout" class="btn btn-danger btn-sm fw-bold shadow-sm"><i class="fa-solid fa-right-from-bracket me-1"></i>Logout</a>
                    </div>
                    <div class="card-body p-4">
                        
                        @if(session('success'))
                            <div class="alert alert-success fw-bold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
                        @endif

                        <form action="/pelanggan" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold"><i class="fa-solid fa-map-location-dot me-1"></i>Alamat Penjemputan</label>
                                <textarea name="alamat" class="form-control bg-light" rows="2" placeholder="Masukkan alamat lengkap penjemputan..." required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted fw-bold"><i class="fa-solid fa-shirt me-1"></i>Jenis Layanan</label>
                                    <select name="jenis_layanan" class="form-select bg-light" required>
                                        <option value="" disabled selected>-- Pilih Layanan Profesional --</option>
                                        <optgroup label="Pakaian Kiloan">
                                            <option value="Cuci/Gosok Saja">Cuci/Gosok Saja (Rp 5.000/kg)</option>
                                            <option value="Cuci + Gosok">Cuci + Gosok (Rp 7.000/kg)</option>
                                        </optgroup>
                                        <optgroup label="Perawatan Bed Cover">
                                            <option value="Bed Cover - Single (Kecil)">Bed Cover - Single/Kecil (Rp 15.000/pcs)</option>
                                            <option value="Bed Cover - Queen (Sedang)">Bed Cover - Queen/Sedang (Rp 20.000/pcs)</option>
                                            <option value="Bed Cover - King (Besar)">Bed Cover - King/Besar (Rp 30.000/pcs)</option>
                                        </optgroup>
                                        <optgroup label="Perawatan Karpet">
                                            <option value="Karpet - Small (Kecil)">Karpet - Small/Kecil (Rp 40.000/pcs)</option>
                                            <option value="Karpet - Medium (Sedang)">Karpet - Medium/Sedang (Rp 60.000/pcs)</option>
                                            <option value="Karpet - Large (Besar)">Karpet - Large/Besar (Rp 75.000/pcs)</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-muted fw-bold"><i class="fa-solid fa-wallet me-1"></i>Metode Pembayaran</label>
                                    <select name="metode_pembayaran" class="form-select bg-light" required>
                                        <option value="" disabled selected>Pilih cara bayar...</option>
                                        <option value="Cash / Bayar di Toko">Cash / Bayar saat barang diantar kembali</option>
                                        <option value="Transfer Bank BCA">Transfer Bank BCA (No Rek: 123456789)</option>
                                        <option value="QRIS (Scan di Toko)">QRIS</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg w-100 fw-bold shadow-sm"><i class="fa-solid fa-paper-plane me-2"></i>Kirim Pesanan Laundry</button>
                        </form>
                    </div>
                </div>

                <!-- Riwayat Pesanan -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-dark bg-gradient text-white py-3">
                        <h5 class="mb-0"><i class="fa-solid fa-clock-rotate-left me-2"></i>Riwayat Pesanan Saya</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Layanan</th>
                                        <th>Timbang / Jumlah</th>
                                        <th>Total Harga</th>
                                        <th>Metode Bayar</th>
                                        <th>Status Pesanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data_transaksi as $item)
                                    @php $isKiloan = str_contains(strtolower($item->jenis_layanan), 'cuci'); @endphp
                                    <tr>
                                        <td class="ps-4 fw-bold text-secondary">{{ $item->jenis_layanan }}</td>
                                        <td>
                                            @if($item->berat_atau_jumlah > 0)
                                                <span class="fw-bold">{{ $isKiloan ? $item->berat_atau_jumlah : number_format($item->berat_atau_jumlah, 0) }}</span> 
                                                <small class="text-muted">{{ $isKiloan ? 'Kg' : 'Pcs' }}</small>
                                            @else
                                                ⏳ Admin
                                            @endif
                                        </td>
                                        <td class="fw-bold text-success">
                                            @if($item->total_harga > 0) Rp {{ number_format($item->total_harga, 0, ',', '.') }} @else - @endif
                                        </td>
                                        <td><span class="badge bg-light text-dark border">{{ $item->metode_pembayaran }}</span></td>
                                        <td>
                                            @if($item->status_pembayaran == 'Selesai & Lunas')
                                                <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i>Selesai</span>
                                            @elseif($item->status_pembayaran == 'Menunggu Ditimbang')
                                                <span class="badge bg-danger"><i class="fa-solid fa-scale-balanced me-1"></i>Menunggu</span>
                                            @else
                                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-spinner fa-spin me-1"></i>Diproses</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada pesanan.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Fitur Rating -->
                <div class="card shadow-sm border-0 rounded-3 mb-4 bg-white">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold text-dark mb-1"><i class="fa-solid fa-ranking-star text-warning me-2"></i>Nilai Pengalaman Anda</h5>
                        <p class="text-muted small mb-3">Seberapa puas Anda menggunakan layanan aplikasi Laundry Bayu?</p>
                        
                        <form action="/pelanggan/rating" method="POST">
                            @csrf
                            <div class="star-rating mb-3">
                                <input type="radio" id="star5" name="rating" value="5" required><label for="star5" class="fa-solid fa-star"></label>
                                <input type="radio" id="star4" name="rating" value="4"><label for="star4" class="fa-solid fa-star"></label>
                                <input type="radio" id="star3" name="rating" value="3"><label for="star3" class="fa-solid fa-star"></label>
                                <input type="radio" id="star2" name="rating" value="2"><label for="star2" class="fa-solid fa-star"></label>
                                <input type="radio" id="star1" name="rating" value="1"><label for="star1" class="fa-solid fa-star"></label>
                            </div>
                            
                            <div class="mb-3 text-start px-md-5">
                                <textarea name="ulasan" class="form-control bg-light" rows="2" placeholder="Tuliskan ulasan atau saran (opsional)..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-warning fw-bold px-5 text-dark shadow-sm">
                                <i class="fa-solid fa-paper-plane me-2"></i>Kirim Penilaian
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Forum Ulasan -->
                <div class="card shadow-sm border-0 rounded-3 mb-4 bg-white">
                    <div class="card-header bg-light py-3 border-bottom-0">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-comments text-primary me-2"></i>Forum Ulasan Pelanggan</h5>
                    </div>
                    <div class="card-body p-4">
                        @forelse($data_rating as $ulasan)
                            @php
                                $nama = $ulasan->user ? $ulasan->user->name : 'User Terhapus';
                                $sensorNama = strlen($nama) > 3 ? substr($nama, 0, 3) . str_repeat('*', strlen($nama) - 3) : $nama . '***';
                            @endphp
                            <div class="mb-4 border-bottom pb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-dark"><i class="fa-solid fa-circle-user text-secondary me-2"></i>{{ $sensorNama }}</span>
                                    <span class="text-muted small">{{ $ulasan->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-warning mb-2 small">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $ulasan->rating) <i class="fa-solid fa-star"></i>
                                        @else <i class="fa-regular fa-star text-muted" style="opacity: 0.3;"></i> @endif
                                    @endfor
                                </div>
                                <p class="text-muted mb-2 fst-italic" style="font-size: 0.95rem;">
                                    "{{ $ulasan->ulasan ?? 'Memberikan penilaian tanpa ulasan teks.' }}"
                                </p>

                                <!-- TAMPILAN BALASAN ADMIN JIKA ADA -->
                                @if($ulasan->balasan_admin)
                                <div class="bg-light p-3 rounded-3 border-start border-4 border-primary mt-2">
                                    <div class="fw-bold text-primary small mb-1"><i class="fa-solid fa-reply me-1"></i>Balasan Admin:</div>
                                    <p class="text-dark small mb-0">{{ $ulasan->balasan_admin }}</p>
                                </div>
                                @endif

                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fa-regular fa-comment-dots fa-3x text-muted mb-3 opacity-25"></i>
                                <p class="text-muted mb-0">Belum ada ulasan dari pelanggan. Jadilah yang pertama!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="container mt-auto">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <footer class="pt-4 pb-4">
                    <hr class="text-muted opacity-25 mb-3">
                    <div class="row text-muted align-items-center" style="font-size: 0.85rem;">
                        <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                            &copy; 2026 <span class="fw-bold text-dark">Sistem Manajemen Laundry Bayu</span><br>
                            Dikembangkan oleh Muhamad Bayu Nugroho - Semua Hak Dilindungi.
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <a href="#" class="text-decoration-none text-muted">Kebijakan Privasi</a> &middot; 
                            <a href="#" class="text-decoration-none text-muted">Syarat & Ketentuan</a><br>
                            <span class="fst-italic">Hak Akses: <span class="fw-bold text-dark">{{ ucfirst(Auth::user()->role) }}</span></span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>