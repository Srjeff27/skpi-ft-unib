<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKPI</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .header { text-align: center; margin-bottom: 16px; }
        .title { font-weight: bold; font-size: 18px; }
        .muted { color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f3f4f6; }
        .qr { text-align: right; margin-top: 12px; }
    </style>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600" rel="stylesheet" />
    <style> body { font-family: 'Inter', DejaVu Sans, sans-serif; } </style>
    <style>@page { margin: 20px 24px; }</style>
    <style> .no-border td, .no-border th { border: none; } </style>
    <style> .small { font-size: 11px; }</style>
</head>
<body>
    <div class="header">
        <div class="title">Surat Keterangan Pendamping Ijazah (SKPI)</div>
        <div class="muted">Fakultas Teknik, Universitas Bengkulu</div>
    </div>

    <table class="no-border" style="margin-bottom: 8px;">
        <tr>
            <td class="small"><strong>Nama</strong>: {{ $user->name }}</td>
            <td class="small"><strong>NIM</strong>: {{ $user->nim ?? '-' }}</td>
        </tr>
        <tr>
            <td class="small"><strong>Program Studi</strong>: {{ optional($user->prodi)->nama_prodi ?? '-' }}</td>
            <td class="small"><strong>Nomor SKPI</strong>: {{ $user->nomor_skpi ?? '-' }}</td>
        </tr>
    </table>

    <div style="margin: 10px 0 6px; font-weight: 600;">Portofolio Terverifikasi</div>
    <table>
        <thead>
            <tr>
                <th style="width: 28%">Nama Dokumen</th>
                <th style="width: 22%">Kategori</th>
                <th style="width: 18%">Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($verifiedPortfolios as $p)
            <tr>
                <td>{{ $p->judul_kegiatan }}</td>
                <td>{{ $p->kategori_portfolio }}</td>
                <td>{{ optional($p->tanggal_dokumen)->format('d/m/Y') }}</td>
                <td>{{ $p->deskripsi_kegiatan }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="small">Belum ada portofolio terverifikasi.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="qr">
        <div class="small">Verifikasi dokumen:</div>
        <img src="{{ $qrBase64 }}" alt="QR" width="96" height="96" />
    </div>
</body>
</html>

