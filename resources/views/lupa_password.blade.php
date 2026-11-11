<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Laundry Bayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%) !important;">
    <div class="card shadow border-0 p-4 rounded-4" style="width: 400px;">
        <h4 class="fw-bold mb-3 text-primary">Reset Password</h4>
        <form action="/lupa-password" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold small">Email Terdaftar</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold small">Password Baru</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold">Perbarui Password</button>
        </form>
        <div class="text-center mt-3">
            <a href="/login" class="text-decoration-none small">Kembali ke Login</a>
        </div>
    </div>
</body>
</html>