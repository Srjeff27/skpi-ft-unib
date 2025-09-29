<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi SKPI</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; margin: 24px; color: #0f172a; }
        .card { max-width: 700px; margin: 0 auto; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; }
        .muted { color: #64748b; }
        .ok { color: #16a34a; font-weight: 600; }
    </style>
    <script>
        // Disable embedding
        if (window.top !== window.self) window.top.location = window.location;
    </script>
</head>
<body>
    <div class="card">
        <h1 style="font-size: 20px; font-weight: 700; margin: 0 0 8px;">Verifikasi Dokumen SKPI</h1>
        <p class="muted" style="margin:0 0 16px;">Fakultas Teknik, Universitas Bengkulu</p>

        <div style="margin: 10px 0 16px;">
            <div><strong>Nama:</strong> {{ $user->name }}</div>
            <div><strong>NIM:</strong> {{ $user->nim ?? '-' }}</div>
            <div><strong>Program Studi:</strong> {{ optional($user->prodi)->nama_prodi ?? '-' }}</div>
        </div>

        <div style="margin: 16px 0;">
            <div class="ok">Dokumen ini terverifikasi.</div>
            <div class="muted">Portofolio terverifikasi: {{ $verifiedCount }}</div>
        </div>
        <p class="muted" style="font-size: 12px;">Halaman ini diakses melalui tautan bertanda tangan yang dikeluarkan sistem.</p>
    </div>
</body>
</html>

