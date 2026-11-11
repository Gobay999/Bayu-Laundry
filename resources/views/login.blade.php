<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laundry Bayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="d-flex flex-column min-vh-100 justify-content-between bg-light" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%) !important;">
    
    <div class="container my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                
                <!-- Brand Header -->
                <div class="text-center mb-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm mb-3" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-shirt fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-dark">Laundry Bayu</h3>
                    <p class="text-muted small">Sistem Manajemen & Pemesanan Laundry</p>
                </div>

                <!-- Card Form Login -->
                <div class="card shadow-lg border-0 rounded-4 p-4 bg-white">
                    <div class="card-body">
                        <h5 class="fw-bold text-dark mb-4 text-center"><i class="fa-solid fa-right-to-bracket me-2 text-primary"></i>Masuk ke Akun Anda</h5>

                        @if(session('success'))
                            <div class="alert alert-success fw-bold small shadow-sm"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger fw-bold small shadow-sm"><i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}</div>
                        @endif

                        <form action="/login" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold small">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control bg-light border-start-0" placeholder="nama@email.com" required autofocus>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold small">Kata Sandi (Password)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control bg-light border-start-0" placeholder="••••••••" required>
                                </div>
                            </div>

                            <!-- Menu Bantuan / Lupa Akses -->
                            <div class="d-flex justify-content-between align-items-center mb-4" style="font-size: 0.85rem;">
                                <a href="/lupa-password" class="text-decoration-none text-primary fw-semibold"><i class="fa-solid fa-key me-1"></i>Lupa Password?</a>
                                <a href="/lupa-email" class="text-decoration-none text-muted"><i class="fa-solid fa-circle-question me-1"></i>Lupa Email?</a>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm mb-3">
                                <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Masuk Sekarang
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <span class="text-muted small">Belum punya akun?</span> 
                            <a href="/register" class="text-primary fw-bold text-decoration-none small">Daftar di sini</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- FOOTER CREDIT -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <footer class="pt-3 pb-4 text-center">
                    <hr class="text-muted opacity-25 mb-3">
                    <div class="text-muted" style="font-size: 0.82rem;">
                        &copy; 2026 <span class="fw-bold text-dark">Sistem Manajemen Laundry Bayu</span>. 
                        Dikembangkan oleh Muhamad Bayu Nugroho.<br>
                        <span class="fst-italic text-secondary">Akses Gerbang Autentikasi Sistem</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>