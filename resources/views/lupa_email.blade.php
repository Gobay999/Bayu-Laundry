<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cari Email - Laundry Bayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%) !important;">
    <div class="card shadow border-0 p-4 rounded-4" style="width: 400px;">
        <h4 class="fw-bold mb-3 text-primary">Cari Akun Saya</h4>
        @if(session('success'))
            <div class="alert alert-success small fw-bold">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger small fw-bold">{{ session('error') }}</div>
        @endif
        <form action="/lupa-email" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold small">Masukkan Nama Lengkap Anda</label>
                <input type="text" name="name" class="form-control" placeholder="Nama saat mendaftar" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold">Cari Email</button>
        </form>
        <div class="text-center mt-3">
            <a href="/login" class="text-decoration-none small">Kembali ke Login</a>
        </div>
    </div>
</body>
</html>