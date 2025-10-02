<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Pendamping Ijazah (SKPI) - {{ $user->name }}</title>
    <style>
        @page {
            margin: 25px 30px;
        }
        body {
            font-family: 'DejaVu Sans', 'Times New Roman', Times, serif;
            font-size: 10px;
            color: #000;
            line-height: 1.4;
        }
        .en {
            font-style: italic;
            color: #555;
        }
        .container {
            width: 100%;
            border-collapse: collapse;
        }
        .section-title {
            background-color: #e5e7eb;
            padding: 4px 6px;
            font-weight: bold;
            font-size: 11px;
            margin: 12px 0 6px 0;
            border-radius: 3px;
        }
        .section-content {
            padding-left: 2px;
        }
        .info-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .info-list li {
            margin-bottom: 3px;
        }
        .info-list strong {
            min-width: 120px;
            display: inline-block;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        .data-table th,
        .data-table td {
            border: 1px solid #ccc;
            padding: 5px;
            vertical-align: top;
            text-align: left;
        }
        .data-table th {
            background-color: #f3f4f6;
            font-weight: bold;
            font-size: 9.5px;
        }
        .data-table td {
            font-size: 9.5px;
        }
        .cpl-list {
            padding-left: 15px;
            margin: 0;
        }
        .cpl-list li {
            margin-bottom: 5px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .doc-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 10px;
        }
        .doc-subtitle {
            text-align: center;
            font-size: 12px;
            font-style: italic;
            margin-bottom: 5px;
        }
        .signature-box {
            margin-top: 50px;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            z-index: -1000;
        }
        footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 3px;
        }
    </style>
</head>

<body>
    @php
    use App\Models\Setting;
    use App\Models\Curriculum;
    use App\Models\CplItem;
    use App\Models\Finalization;
    use App\Models\Official;

    // Settings (institution)
    $univ = Setting::get('univ_name', 'Universitas Bengkulu');
    $faculty = Setting::get('faculty_name', 'Fakultas Teknik');
    $skpt = Setting::get('sk_pt');
    $grading = Setting::get('grading');
    $admission = Setting::get('admission');
    $languages = Setting::get('languages', 'Indonesia & English');
    $contact = Setting::get('contact');
    $logoPath = Setting::get('logo_path');

    // Finalization & Official for graduation period
    $periodYm = $user->tanggal_lulus ? date('Y-m', strtotime($user->tanggal_lulus)) : null;
    $fin = $periodYm ? Finalization::where('period_ym', $periodYm)->with('official')->first() : null;
    $official = $fin?->official ?: Official::where('is_active', true)->first();
    $signatureSrc = null;
    if ($official?->signature_path) {
        $local = storage_path('app/public/' . $official->signature_path);
        if (is_file($local)) $signatureSrc = 'data:image/png;base64,' . base64_encode(file_get_contents($local));
    }

    // Active curriculum & CPL
    $activeCurr = $user->prodi_id ? Curriculum::where('prodi_id', $user->prodi_id)->where('is_active', true)->first() : null;
    $cpl = collect();
    if ($activeCurr) {
        $cpl = CplItem::where('curriculum_id', $activeCurr->id)
            ->orderBy('category')->orderBy('order')->get()->groupBy('category');
    }
    @endphp

    @if ($logoPath && is_file(storage_path('app/public/' . $logoPath)))
    <div class="watermark">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $logoPath))) }}" width="300" />
    </div>
    @endif

    <footer>
        Nomor SKPI / Diploma Supplement Number: {{ $user->nomor_skpi ?? '-' }}
    </footer>

    <table class="container">
        <thead>
            <tr>
                <th>
                    <table class="header-table">
                        <tr>
                            <td style="width: 15%; text-align: center;">
                                @if ($logoPath && is_file(storage_path('app/public/' . $logoPath)))
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $logoPath))) }}" alt="Logo" height="70">
                                @endif
                            </td>
                            <td style="width: 85%; text-align: center; line-height: 1.3;">
                                <div style="font-size: 11px; font-weight: bold; text-transform: uppercase;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</div>
                                <div style="font-size: 14px; font-weight: bold; text-transform: uppercase;">{{ $univ }}</div>
                                <div style="font-size: 12px; font-weight: bold; text-transform: uppercase;">{{ $faculty }}</div>
                                <div style="font-size: 9px;">{!! nl2br(e($contact)) !!}</div>
                            </td>
                        </tr>
                    </table>
                    <div class="doc-title">Surat Keterangan Pendamping Ijazah</div>
                    <div class="doc-subtitle">Diploma Supplement</div>
                    <div style="text-align: center; font-size: 10px; margin-bottom: 10px;">Nomor: {{ $user->nomor_skpi ?? '-' }}</div>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="section-title">1. INFORMASI MENGENAI IDENTITAS PEMEGANG SKPI <span class="en">/ Information Identifying the Holder of the Diploma Supplement</span></div>
                    <div class="section-content">
                        <ul class="info-list">
                            <li><strong>Nama Lengkap <span class="en">/ Full Name</span></strong>: {{ $user->name }}</li>
                            <li><strong>Tempat & Tgl. Lahir <span class="en">/ Place & Date of Birth</span></strong>: {{ trim($user->tempat_lahir . ' ' . ($user->tanggal_lahir ? ', ' . \Carbon\Carbon::parse($user->tanggal_lahir)->format('d F Y') : '')) ?: '-' }}</li>
                            <li><strong>NIM <span class="en">/ Student ID Number</span></strong>: {{ $user->nim ?? '-' }}</li>
                            <li><strong>Tanggal Lulus <span class="en">/ Date of Graduation</span></strong>: {{ $user->tanggal_lulus ? \Carbon\Carbon::parse($user->tanggal_lulus)->format('d F Y') : '-' }}</li>
                            <li><strong>No. Ijazah <span class="en">/ Diploma Number</span></strong>: {{ $user->nomor_ijazah ?? '-' }}</li>
                            <li><strong>Gelar <span class="en">/ Title</span></strong>: {{ optional($user->prodi)->gelar ?? '-' }}</li>
                        </ul>
                    </div>

                    <div class="section-title">2. INFORMASI MENGENAI IDENTITAS PENYELENGGARA PROGRAM <span class="en">/ Information Identifying the Awarding Institution</span></div>
                    <div class="section-content">
                        <ul class="info-list">
                            <li><strong>SK Pendirian PT <span class="en">/ Decree</span></strong>: {{ $skpt ?: '-' }}</li>
                            <li><strong>Program Studi <span class="en">/ Study Program</span></strong>: {{ optional($user->prodi)->nama_prodi ?? '-' }} ({{ optional($user->prodi)->jenjang ?? '-' }})</li>
                            <li><strong>Persyaratan Penerimaan <span class="en">/ Entry Requirements</span></strong>: {!! nl2br(e($admission)) !!}</li>
                            <li><strong>Bahasa Pengantar <span class="en">/ Language of Instruction</span></strong>: {{ $languages }}</li>
                            <li><strong>Sistem Penilaian <span class="en">/ Grading System</span></strong>: {!! nl2br(e($grading)) !!}</li>
                        </ul>
                    </div>

                    <div class="section-title">3. INFORMASI MENGENAI KUALIFIKASI DAN HASIL YANG DICAPAI <span class="en">/ Information on the Qualification and Outcomes</span></div>
                    <div class="section-content">
                        @if ($activeCurr)
                        <div style="font-size: 9.5px; margin-bottom: 5px;">Kurikulum <span class="en">/ Curriculum</span>: <strong>{{ $activeCurr->name }} ({{ $activeCurr->year ?? '-' }})</strong></div>
                        @endif
                        @php
                        $cplLabels = [
                            'sikap' => 'a. Sikap dan Tata Nilai / a. Attitude and Values',
                            'pengetahuan' => 'b. Penguasaan Pengetahuan / b. Knowledge',
                            'umum' => 'c. Keterampilan Umum / c. General Skills',
                            'khusus' => 'd. Keterampilan Khusus / d. Specific Skills',
                        ];
                        @endphp
                        @foreach ($cplLabels as $cat => $label)
                        <div style="font-weight: bold; font-size: 10px; margin-top: 5px;">{{ $label }}</div>
                        <ul class="cpl-list">
                            @forelse(($cpl[$cat] ?? collect()) as $it)
                            <li>{!! e($it->desc_id) !!}<br><span class="en">{!! e($it->desc_en) !!}</span></li>
                            @empty
                            <li><span class="en">- Not Available -</span></li>
                            @endforelse
                        </ul>
                        @endforeach
                    </div>

                    <div class="section-title">4. PRESTASI DAN PENGHARGAAN <span class="en">/ Achievements and Awards</span></div>
                    <div class="section-content">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Uraian Kegiatan <span class="en">/ Description</span></th>
                                    <th style="width:25%">Tanggal <span class="en">/ Date</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($verifiedPortfolios as $p)
                                <tr>
                                    <td>
                                        <strong>{{ $p->judul_kegiatan }}</strong>
                                        <div class="en">{{ $p->kategori_portfolio }}</div>
                                    </td>
                                    <td>{{ $p->tanggal_dokumen ? \Carbon\Carbon::parse($p->tanggal_dokumen)->format('d M Y') : '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2"><span class="en">No verified achievements recorded.</span></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="section-title">5. PENGESAHAN SKPI <span class="en">/ Official Endorsement</span></div>
                    <div class="section-content">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 65%; vertical-align: top;">
                                    Bengkulu, {{ now()->format('d F Y') }}
                                    <br>
                                    {{ $official->jabatan ?? '-' }}
                                    <div class="signature-box">
                                        @if ($signatureSrc)
                                        <img src="{{ $signatureSrc }}" alt="Signature" style="height:60px; object-fit:contain;" />
                                        @else
                                        <div style="height:60px; color: #aaa;">[tanda tangan digital]</div>
                                        @endif
                                    </div>
                                    <div style="font-weight: bold; text-decoration: underline;">{{ $official->display_name ?? '-' }}</div>
                                    <div>NIP. {{ $official->nip ?? '-' }}</div>
                                </td>
                                <td style="width: 35%; vertical-align: bottom; text-align: right;">
                                    <img src="{{ $qrBase64 }}" alt="QR Code" width="80" height="80" />
                                    <div style="font-size: 8px;">Verifikasi Keaslian Dokumen <br><span class="en">Verify Document Authenticity</span></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>

