<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        h1 { font-size: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>Laporan Ringkas Portofolio</h1>
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Verified</td><td>{{ $byStatus['verified'] }}</td></tr>
            <tr><td>Rejected</td><td>{{ $byStatus['rejected'] }}</td></tr>
            <tr><td>Pending</td><td>{{ $byStatus['pending'] }}</td></tr>
        </tbody>
    </table>
</body>
</html>

