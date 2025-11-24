<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Pendamping Ijazah (SKPI) - {{ $user->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4;
            margin: 1.5cm;
        }

        body {
            font-family: 'Poppins', 'Arial', sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.15;
            background-color: #fff;
            position: relative;
        }

        .en {
            font-style: italic;
            color: #555;
            font-weight: 400;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.05;
            z-index: -1;
            pointer-events: none;
        }

        /* --- Header --- */
        .header {
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 3px double #333;
            margin-bottom: 20px;
        }

        .header img {
            height: 80px;
            margin-bottom: 10px;
        }

        .header .ministry {
            font-size: 12pt;
            font-weight: 600;
            text-transform: uppercase;
        }

        .header .university,
        .header .faculty {
            font-size: 14pt;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 3px;
        }

        .header .faculty {
            font-size: 13pt;
        }

        .header .contact {
            font-size: 8pt;
            line-height: 1.3;
            margin-top: 5px;
            color: #444;
        }

        /* --- Document Title --- */
        .doc-title-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .doc-title {
            font-size: 15pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .doc-subtitle {
            font-size: 13pt;
            font-style: italic;
            color: #555;
            margin-top: 2px;
        }

        .doc-number {
            font-size: 10pt;
            margin-top: 5px;
        }

        /* --- Sections --- */
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .section-title {
            font-weight: 600;
            font-size: 11pt;
            padding-bottom: 4px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .section-title .en {
            font-weight: 500;
        }

        .section-content {
            padding-left: 5px;
        }

        /* --- Info Table --- */
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 220px;
            font-weight: 500;
        }

        .info-table td:nth-child(2) {
            width: 15px;
            text-align: center;
        }

        /* --- CPL / Outcomes List --- */
        .cpl-category {
            font-weight: 600;
            font-size: 10pt;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .cpl-list {
            padding-left: 20px;
            margin: 0;
            list-style-type: '•  ';
        }

        .cpl-list li {
            margin-bottom: 8px;
            padding-left: 5px;
        }

        .cpl-list .en {
            display: block;
        }


        /* --- Achievements Table --- */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            vertical-align: top;
            text-align: left;
        }

        .data-table thead {
            background-color: #f8f9fa;
        }

        .data-table th {
            font-weight: 600;
            font-size: 10pt;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #fdfdff;
        }

        .data-table .en {
            font-size: 9pt;
            display: block;
            margin-top: 2px;
        }

        .data-table .no-data {
            text-align: center;
            padding: 20px;
            color: #777;
            font-style: italic;
        }

        /* --- Endorsement Section --- */
        .endorsement-table {
            width: 100%;
            margin-top: 20px;
            text-align: center;
        }

        .endorsement-content {
            vertical-align: top;
        }

        .signature-box {
            height: 70px;
            margin: 10px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signature-box img {
            height: 70px;
            object-fit: contain;
        }

        .signature-box .placeholder {
            color: #aaa;
            font-style: italic;
        }

        .official-name {
            font-weight: 700;
            text-decoration: underline;
            text-decoration-thickness: 1px;
            text-underline-offset: 3px;
        }

        .qr-section {
            margin-top: 15px;
        }

        .qr-section img {
            width: 90px;
            height: 90px;
        }

        .qr-section .qr-label {
            font-size: 8pt;
            margin-top: 5px;
        }

        /* --- Footer --- */
        footer {
            position: fixed;
            bottom: -1.5cm;
            left: -1.5cm;
            right: -1.5cm;
            height: 30px;
            text-align: center;
            font-size: 9pt;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            background-color: #fff;
        }
    </style>
</head>

<body>
    @php
        use App\Models\Setting;
        use App\Models\Curriculum;
        use App\Models\CplItem;
        use App\Models\Finalization;
        use Illuminate\Support\Facades\Schema;
        use App\Models\Official;
        use Carbon\Carbon;

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
        $fin = null;
        if ($periodYm && Schema::hasTable('finalizations')) {
            $fin = Finalization::where('period_ym', $periodYm)->with('official')->first();
        }
        $official = $fin?->official ?: Official::where('is_active', true)->first();
        $signatureSrc = null;
        if ($official?->signature_path) {
            $local = storage_path('app/public/' . $official->signature_path);
            if (is_file($local)) {
                $signatureSrc = 'data:image/png;base64,' . base64_encode(file_get_contents($local));
            }
        }

        // Active curriculum & CPL
        $activeCurr = $user->prodi_id
            ? Curriculum::where('prodi_id', $user->prodi_id)->where('is_active', true)->first()
            : null;
        $cpl = collect();
        if ($activeCurr) {
            $cpl = CplItem::where('curriculum_id', $activeCurr->id)
                ->orderBy('category')
                ->orderBy('order')
                ->get()
                ->groupBy('category');
        }

        // Set locale for date formatting
        Carbon::setLocale('id');

    @endphp

    @if ($logoPath && is_file(storage_path('app/public/' . $logoPath)))
        <div class="watermark">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $logoPath))) }}"
                width="350" />
        </div>
    @endif

    <footer>
        Nomor SKPI / <span class="en">Diploma Supplement Number</span>: {{ $user->nomor_skpi ?? '-' }}
    </footer>

    <header class="header">
        @if ($logoPath && is_file(storage_path('app/public/' . $logoPath)))
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $logoPath))) }}"
                alt="Logo">
        @endif
        <div class="ministry">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</div>
        <div class="university">{{ $univ }}</div>
        <div class="faculty">{{ $faculty }}</div>
        <div class="contact">{!! nl2br(e($contact)) !!}</div>
    </header>

    <main>
        <div class="doc-title-container">
            <div class="doc-title">Surat Keterangan Pendamping Ijazah</div>
            <div class="doc-subtitle">Diploma Supplement</div>
            <div class="doc-number">Nomor: {{ $user->nomor_skpi ?? '-' }}</div>
        </div>

        @php
            $achievements = $verifiedPortfolios ?? collect();
            $organizationPortfolios = $achievements->filter(fn($p) => str_contains(strtolower($p->kategori_portfolio ?? ''), 'organisasi'));
            $internshipPortfolios = $achievements->filter(fn($p) => str_contains(strtolower($p->kategori_portfolio ?? ''), 'magang') || str_contains(strtolower($p->kategori_portfolio ?? ''), 'intern'));
            $finalProjectId = $user->tugas_akhir_id ?? null;
            $finalProjectEn = $user->tugas_akhir_en ?? null;

            $letter = function ($index) {
                return chr(97 + $index) . '.';
            };
        @endphp

        <div class="section">
            <div class="section-title">1. INFORMASI MENGENAI IDENTITAS PEMEGANG SKPI <span class="en">/ Information
                    Identifying the Holder of the Diploma Supplement</span></div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Nama Lengkap <br><span class="en">Full Name</span></td>
                        <td>:</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Tempat & Tgl. Lahir <br><span class="en">Place & Date of Birth</span></td>
                        <td>:</td>
                        <td>{{ trim($user->tempat_lahir . ' ' . ($user->tanggal_lahir ? ', ' . Carbon::parse($user->tanggal_lahir)->translatedFormat('d F Y') : '')) ?: '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>NIM <br><span class="en">Student ID Number</span></td>
                        <td>:</td>
                        <td>{{ $user->nim ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lulus <br><span class="en">Date of Graduation</span></td>
                        <td>:</td>
                        <td>{{ $user->tanggal_lulus ? Carbon::parse($user->tanggal_lulus)->translatedFormat('d F Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>No. Ijazah <br><span class="en">Diploma Number</span></td>
                        <td>:</td>
                        <td>{{ $user->nomor_ijazah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Gelar <br><span class="en">Title</span></td>
                        <td>:</td>
                        <td>
                            {{ $user->gelar_id ?? '-' }} <br>
                            <span class="en">{{ $user->gelar_en ?? ($user->gelar_id ?? '-') }}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">2. INFORMASI MENGENAI IDENTITAS PENYELENGGARA PROGRAM <span class="en">/
                    Information Identifying the Awarding Institution</span></div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>SK Pendirian PT <br><span class="en">Decree</span></td>
                        <td>:</td>
                        <td>{{ $skpt ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Program Studi <br><span class="en">Study Program</span></td>
                        <td>:</td>
                        <td>{{ optional($user->prodi)->nama_prodi ?? '-' }}
                            ({{ optional($user->prodi)->jenjang ?? '-' }})</td>
                    </tr>
                    <tr>
                        <td>Persyaratan Penerimaan <br><span class="en">Entry Requirements</span></td>
                        <td>:</td>
                        <td>{!! nl2br(e($admission)) !!}</td>
                    </tr>
                    <tr>
                        <td>Bahasa Pengantar <br><span class="en">Language of Instruction</span></td>
                        <td>:</td>
                        <td>{{ $languages }}</td>
                    </tr>
                    <tr>
                        <td>Sistem Penilaian <br><span class="en">Grading System</span></td>
                        <td>:</td>
                        <td>{!! nl2br(e($grading)) !!}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">3. INFORMASI MENGENAI KUALIFIKASI DAN HASIL YANG DICAPAI <span class="en">/
                    Information on the Qualification and Outcomes</span></div>
            <div class="section-content">
                @if ($activeCurr)
                    <div style="font-size: 10pt; margin-bottom: 10px;">Kurikulum <span class="en">/
                            Curriculum</span>: <strong>{{ $activeCurr->name }}
                            ({{ $activeCurr->year ?? '-' }})</strong></div>
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
                    <div class="cpl-category">{{ $label }}</div>
                    <ul class="cpl-list">
                        @forelse(($cpl[$cat] ?? collect()) as $it)
                            <li>{!! e($it->desc_id) !!}<span class="en">{!! e($it->desc_en) !!}</span></li>
                        @empty
                            <li><span class="en">- Not Available -</span></li>
                        @endforelse
                    </ul>
                @endforeach
            </div>
        </div>

        <div class="section">
            <div class="section-title">3.2 INFORMASI TAMBAHAN <span class="en">/ Additional Information</span></div>
            <div class="section-content">
                <table style="width:100%; border-collapse:collapse; font-size:10pt;">
                    <tr>
                        <td style="width:50%; text-align:center; font-weight:700;">Bahasa Indonesia</td>
                        <td style="width:50%; text-align:center; font-weight:700;" class="en">Bahasa Inggris</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top; padding-top:8px;">
                            <div style="text-align:center; font-weight:700; margin-bottom:6px;">Penghargaan dan Pemenang Kejuaraan</div>
                            <ol style="margin:0; padding-left:16px;">
                                @forelse($achievements as $idx => $p)
                                    <li style="margin-bottom:2px;">{{ $p->nama_dokumen_id ?? $p->judul_kegiatan }}</li>
                                @empty
                                    <li>-</li>
                                @endforelse
                            </ol>

                            <div style="text-align:center; font-weight:700; margin:14px 0 6px;">Pengalaman Organisasi</div>
                            <ol style="margin:0; padding-left:16px;">
                                @forelse($organizationPortfolios as $p)
                                    <li style="margin-bottom:2px;">{{ $p->nama_dokumen_id ?? $p->judul_kegiatan }}</li>
                                @empty
                                    <li>-</li>
                                @endforelse
                            </ol>

                            <div style="text-align:center; font-weight:700; margin:14px 0 6px;">Spesifikasi Tugas Akhir</div>
                            <div style="text-align:center;">{{ $finalProjectId ?: '-' }}</div>

                            <div style="text-align:center; font-weight:700; margin:14px 0 6px;">Bahasa Internasional</div>
                            <div style="text-align:center;">{{ $user->bahasa_internasional ?? '-' }}</div>

                            <div style="text-align:center; font-weight:700; margin:14px 0 6px;">Magang / Industri</div>
                            <ol style="margin:0; padding-left:16px;">
                                @forelse($internshipPortfolios as $p)
                                    <li style="margin-bottom:2px;">{{ $p->nama_dokumen_id ?? $p->judul_kegiatan }}</li>
                                @empty
                                    <li>-</li>
                                @endforelse
                            </ol>

                            <div style="text-align:center; font-weight:700; margin:14px 0 6px;">Pendidikan Karakter</div>
                            <div style="text-align:center;">{{ $user->pendidikan_karakter ?? '-' }}</div>
                        </td>
                        <td style="vertical-align:top; padding-top:8px;">
                            <div style="text-align:center; font-weight:700; margin-bottom:6px;" class="en">Certificates of Honors and Awards</div>
                            <ol style="margin:0; padding-left:16px;">
                                @forelse($achievements as $idx => $p)
                                    <li style="margin-bottom:2px;">{{ $p->nama_dokumen_en ?? $p->judul_kegiatan }}</li>
                                @empty
                                    <li>-</li>
                                @endforelse
                            </ol>

                            <div style="text-align:center; font-weight:700; margin:14px 0 6px;" class="en">Organizational Experiences</div>
                            <ol style="margin:0; padding-left:16px;">
                                @forelse($organizationPortfolios as $p)
                                    <li style="margin-bottom:2px;">{{ $p->nama_dokumen_en ?? $p->judul_kegiatan }}</li>
                                @empty
                                    <li>-</li>
                                @endforelse
                            </ol>

                            <div style="text-align:center; font-weight:700; margin:14px 0 6px;" class="en">Specification of The Final Project</div>
                            <div style="text-align:center;">{{ $finalProjectEn ?: ($finalProjectId ?: '-') }}</div>

                            <div style="text-align:center; font-weight:700; margin:14px 0 6px;" class="en">International Language</div>
                            <div style="text-align:center;">{{ $user->international_language ?? ($user->bahasa_internasional ?? '-') }}</div>

                            <div style="text-align:center; font-weight:700; margin:14px 0 6px;" class="en">Internship</div>
                            <ol style="margin:0; padding-left:16px;">
                                @forelse($internshipPortfolios as $p)
                                    <li style="margin-bottom:2px;">{{ $p->nama_dokumen_en ?? $p->judul_kegiatan }}</li>
                                @empty
                                    <li>-</li>
                                @endforelse
                            </ol>

                            <div style="text-align:center; font-weight:700; margin:14px 0 6px;" class="en">Soft Skill Training</div>
                            <div style="text-align:center;">{{ $user->soft_skill_training ?? ($user->pendidikan_karakter ?? '-') }}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">4. PRESTASI DAN PENGHARGAAN <span class="en">/ Achievements and Awards</span>
            </div>
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
                                    <span class="en">{{ $p->kategori_portfolio }}</span>
                                </td>
                                <td>{{ $p->tanggal_dokumen ? Carbon::parse($p->tanggal_dokumen)->translatedFormat('d M Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="no-data"><span class="en">No verified achievements
                                        recorded.</span></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">5. PENGESAHAN SKPI <span class="en">/ Official Endorsement</span></div>
            <div class="section-content">
                <table class="endorsement-table">
                    <tr>
                        <td class="endorsement-content">
                            Bengkulu, {{ Carbon::now()->translatedFormat('d F Y') }}
                            <br>
                            {{ $official->jabatan ?? 'Pejabat Berwenang' }}
                            <div class="signature-box">
                                @if ($signatureSrc)
                                    <img src="{{ $signatureSrc }}" alt="Signature" />
                                @else
                                    <div class="placeholder">[ Digital Signature ]</div>
                                @endif
                            </div>
                            <div class="official-name">{{ $official->display_name ?? '-' }}</div>
                            <div>NIP. {{ $official->nip ?? '-' }}</div>

                            <div class="qr-section">
                                @if (isset($qrBase64) && $qrBase64)
                                    <img src="{{ $qrBase64 }}" alt="QR Code" />
                                    <div class="qr-label">Verifikasi Keaslian Dokumen <br><span class="en">Verify
                                            Document Authenticity</span></div>
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </main>

</body>

</html>
