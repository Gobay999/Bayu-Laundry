<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Laundry Bayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100" style="background-color: #f4f6f9 !important;">
    <div class="container mt-5 flex-grow-1">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary"><i class="fa-solid fa-cash-register me-2"></i>Dashboard Admin</h3>
            <a href="/logout" class="btn btn-danger fw-bold shadow-sm"><i class="fa-solid fa-power-off me-1"></i>Logout</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success fw-bold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger fw-bold shadow-sm"><i class="fa-solid fa-triangle-exclamation me-2"></i>Terdapat kesalahan input.</div>
        @endif

        <!-- Navigasi -->
        <ul class="nav nav-pills mb-4 shadow-sm bg-white p-2 rounded-3" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold text-dark px-4" data-bs-toggle="pill" data-bs-target="#antrean" type="button" role="tab"><i class="fa-solid fa-users-rectangle me-2"></i>Antrean Pesanan</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-dark px-4" data-bs-toggle="pill" data-bs-target="#pelanggan" type="button" role="tab"><i class="fa-solid fa-users-gear me-2"></i>Kelola Pelanggan</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-dark px-4" data-bs-toggle="pill" data-bs-target="#ulasan" type="button" role="tab"><i class="fa-solid fa-comments me-2"></i>Forum Ulasan</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-dark px-4" data-bs-toggle="pill" data-bs-target="#profil" type="button" role="tab"><i class="fa-solid fa-user-shield me-2"></i>Pengaturan Profil</button>
            </li>
        </ul>

        <!-- Konten -->
        <div class="tab-content" id="adminTabsContent">
            
            <!-- Tab Antrean -->
            <div class="tab-pane fade show active" id="antrean" role="tabpanel">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary bg-gradient text-white py-3">
                        <h5 class="mb-0"><i class="fa-solid fa-list-check me-2"></i>Daftar Antrean Cucian</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Pelanggan & Alamat</th>
                                        <th>Layanan & Pembayaran</th>
                                        <th>Timbang / Jumlah</th>
                                        <th>Total Harga</th>
                                        <th>Status Pesanan</th>
                                        <th class="text-center">Aksi Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data_transaksi as $item)
                                    @php $isKiloan = str_contains(strtolower($item->jenis_layanan), 'cuci'); @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-bold text-primary"><i class="fa-solid fa-user me-1"></i> {{ $item->nama_pelanggan }}</span><br>
                                            <small class="text-muted"><i class="fa-solid fa-location-dot me-1"></i> {{ $item->alamat ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $item->jenis_layanan }}</span><br>
                                            <span class="badge bg-secondary"><i class="fa-solid fa-wallet me-1"></i> {{ $item->metode_pembayaran }}</span>
                                        </td>
                                        <td>
                                            @if($item->status_pembayaran == 'Menunggu Ditimbang')
                                                <form action="/kasir/{{ $item->id }}/timbang" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group input-group-sm shadow-sm" style="width: 140px;">
                                                        @if($isKiloan)
                                                            <input type="number" step="0.1" min="0.1" name="berat" class="form-control border-primary" placeholder="Kg" required>
                                                            <span class="input-group-text bg-white border-primary text-muted px-2">Kg</span>
                                                        @else
                                                            <input type="number" step="1" min="1" name="berat" class="form-control border-primary" placeholder="Pcs" required>
                                                            <span class="input-group-text bg-white border-primary text-muted px-2">Pcs</span>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-calculator"></i></button>
                                                    </div>
                                                </form>
                                            @else
                                                <span class="fw-bold fs-6">
                                                    @if($isKiloan)
                                                        {{ $item->berat_atau_jumlah }} <small class="text-muted">Kg</small>
                                                    @else
                                                        {{ number_format($item->berat_atau_jumlah, 0) }} <small class="text-muted">Pcs</small>
                                                    @endif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="fw-bold text-success fs-6">
                                            @if($item->total_harga > 0)
                                                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                            @else
                                                <span class="text-muted fw-normal">Menunggu...</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status_pembayaran == 'Selesai & Lunas')
                                                <span class="badge bg-success"><i class="fa-solid fa-check-double me-1"></i>Selesai</span>
                                            @elseif($item->status_pembayaran == 'Menunggu Ditimbang')
                                                <span class="badge bg-danger"><i class="fa-solid fa-bell me-1"></i>Menunggu</span>
                                            @else
                                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-washing-machine me-1"></i>Diproses</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($item->status_pembayaran == 'Sedang Diproses')
                                                <form action="/kasir/{{ $item->id }}/status" method="POST" class="d-inline">
                                                    @csrf @method('PUT')
                                                    <button class="btn btn-success btn-sm mb-1 fw-bold"><i class="fa-solid fa-check me-1"></i>Selesaikan</button>
                                                </form>
                                            @endif
                                            @if($item->status_pembayaran == 'Selesai & Lunas')
                                                <a href="/kasir/{{ $item->id }}/struk" target="_blank" class="btn btn-dark btn-sm mb-1"><i class="fa-solid fa-print me-1"></i>Cetak</a>
                                            @endif
                                            <form action="/kasir/{{ $item->id }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm mb-1" onclick="return confirm('Hapus pesanan ini?')"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="text-center py-5 text-muted">Belum Ada Antrean Masuk</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Pelanggan -->
            <div class="tab-pane fade" id="pelanggan" role="tabpanel">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-dark bg-gradient text-white py-3">
                        <h5 class="mb-0"><i class="fa-solid fa-users me-2"></i>Daftar Pengguna Aplikasi</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">ID</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Email</th>
                                        <th>Tanggal Mendaftar</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data_pelanggan as $plg)
                                    <tr>
                                        <td class="ps-4 fw-bold">#{{ $plg->id }}</td>
                                        <td class="fw-bold text-dark">{{ $plg->name }}</td>
                                        <td>{{ $plg->email }}</td>
                                        <td class="text-muted">{{ $plg->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning btn-sm fw-bold me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $plg->id }}"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <form action="/admin/pelanggan/{{ $plg->id }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm fw-bold" onclick="return confirm('Hapus akun ini permanen?')"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    
                                    <!-- Modal Edit Pelanggan -->
                                    <div class="modal fade" id="editModal{{ $plg->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title fw-bold">Edit Akun Pelanggan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="/admin/pelanggan/{{ $plg->id }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Nama Lengkap</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $plg->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Alamat Email</label>
                                                            <input type="email" name="email" class="form-control" value="{{ $plg->email }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary fw-bold">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada pelanggan terdaftar.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Ulasan (Manajemen Rating) -->
            <div class="tab-pane fade" id="ulasan" role="tabpanel">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-info bg-gradient text-white py-3">
                        <h5 class="mb-0"><i class="fa-solid fa-comments me-2"></i>Moderasi Forum Ulasan</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Pelanggan</th>
                                        <th>Rating & Ulasan</th>
                                        <th>Status Balasan Admin</th>
                                        <th class="text-center">Kelola & Moderasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data_rating as $ulasan)
                                    <tr>
                                        <td class="ps-4 fw-bold">
                                            {{ $ulasan->user->name ?? 'User Terhapus' }}<br>
                                            <small class="text-muted fw-normal">{{ $ulasan->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="text-warning small mb-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $ulasan->rating) <i class="fa-solid fa-star"></i>
                                                    @else <i class="fa-regular fa-star text-muted" style="opacity: 0.3;"></i> @endif
                                                @endfor
                                            </div>
                                            <span class="fst-italic text-secondary">"{{ $ulasan->ulasan }}"</span>
                                        </td>
                                        <td>
                                            @if($ulasan->balasan_admin)
                                                <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i>Sudah Dibalas</span>
                                            @else
                                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i>Belum Dibalas</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- Tombol Balas/Edit -->
                                            <button type="button" class="btn btn-primary btn-sm fw-bold mb-1" data-bs-toggle="modal" data-bs-target="#balasModal{{ $ulasan->id }}">
                                                <i class="fa-solid fa-reply"></i> Balas
                                            </button>
                                            
                                            <!-- Tombol Hapus Ulasan -->
                                            <form action="/admin/rating/{{ $ulasan->id }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm fw-bold mb-1" onclick="return confirm('Hapus ulasan ini dari forum?')"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                            
                                            <!-- Tombol Banned (Hapus User) -->
                                            @if($ulasan->user)
                                            <form action="/admin/pelanggan/{{ $ulasan->user->id }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-dark btn-sm fw-bold mb-1" onclick="return confirm('BANNED: Yakin ingin menghapus akun user ini permanen beserta ulasannya?')"><i class="fa-solid fa-ban"></i> Banned</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Modal Balas/Moderasi -->
                                    <div class="modal fade" id="balasModal{{ $ulasan->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title fw-bold">Balas & Moderasi Ulasan</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="/admin/rating/{{ $ulasan->id }}/balas" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold small text-muted">Teks Ulasan Pelanggan (Bisa Anda Edit/Sensor)</label>
                                                            <textarea name="ulasan" class="form-control" rows="2">{{ $ulasan->ulasan }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold text-primary">Teks Balasan Admin</label>
                                                            <textarea name="balasan_admin" class="form-control" rows="3" placeholder="Tulis tanggapan Anda di sini..." required>{{ $ulasan->balasan_admin }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary fw-bold">Publikasikan Balasan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada ulasan masuk.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Profil -->
            <div class="tab-pane fade" id="profil" role="tabpanel">
                <div class="card shadow-sm border-0 rounded-3 col-md-6 mx-auto">
                    <div class="card-header bg-secondary bg-gradient text-white py-3">
                        <h5 class="mb-0"><i class="fa-solid fa-user-shield me-2"></i>Kredensial Login Admin</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="/admin/profile" method="POST">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold">Email Admin Baru</label>
                                <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted fw-bold">Password Baru <small class="text-danger fw-normal">(Opsional)</small></label>
                                <input type="password" name="password" class="form-control" placeholder="Ketik sandi baru...">
                            </div>
                            <button type="submit" class="btn btn-success w-100 fw-bold">Simpan Kredensial</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <div class="container mt-auto">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>