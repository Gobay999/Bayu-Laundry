<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Laundry Bayu</title>
    <!-- Menggunakan Bootstrap 5 agar desainnya rapi dan profesional -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Navbar Sederhana -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Laundry Bayu</a>
            <div>
                <a href="/login" class="btn btn-outline-light btn-sm me-2 fw-bold">Login</a>
                <a href="/register" class="btn btn-success btn-sm fw-bold">Daftar Akun</a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama (Hero Section) -->
    <div class="container my-auto py-5 text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold text-dark mb-3">Solusi Kebersihan Pakaian Anda</h1>
                <p class="lead text-muted mb-4">
                    Selamat datang di sistem manajemen Laundry Bayu. Nikmati kemudahan memesan layanan cuci, setrika, hingga perawatan karpet secara online. Kurir kami siap menjemput pakaian kotor Anda!
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="/login" class="btn btn-primary btn-lg px-4 fw-bold shadow-sm">Masuk ke Akun</a>
                    <a href="/register" class="btn btn-outline-secondary btn-lg px-4 fw-bold">Buat Akun Baru</a>
                </div>
            </div>
        </div>

        <!-- Kartu Fitur Layanan -->
        <div class="row text-start mt-5 pt-4">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 h-100 p-3">
                    <h5 class="fw-bold text-primary">Antar Jemput Mudah</h5>
                    <p class="text-muted small">Cukup isi alamat penjemputan di akun Anda, dan kurir kami akan segera datang mengambil cucian.</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 h-100 p-3">
                    <h5 class="fw-bold text-success">Transparan & Realtime</h5>
                    <p class="text-muted small">Admin akan menimbang cucian dan menghitung total harga secara transparan langsung di sistem.</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 h-100 p-3">
                    <h5 class="fw-bold text-dark">Pembayaran Fleksibel</h5>
                    <p class="text-muted small">Pilih metode pembayaran sesuai kenyamanan Anda: Cash di toko, Transfer Bank, atau QRIS.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p class="mb-0 small text-muted">&copy; 2026 Laundry Bayu - Portofolio Web Developer. All rights reserved.</p>
    </footer>

</body>
</html>