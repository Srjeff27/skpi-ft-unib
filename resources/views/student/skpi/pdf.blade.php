<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>SKPI - {{ $user->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 1cm 1.5cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #000;
            line-height: 1.3;
        }

        .en {
            font-style: italic;
            color: #000; /* PDF hitam pekat */
            display: block;
            font-weight: normal;
        }

        /* --- Header --- */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header .faculty {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header .univ {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .skpi-title {
            text-align: center;
            margin-bottom: 5px;
            margin-top: 15px;
        }

        .skpi-title h1 {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .skpi-title h2 {
            font-size: 12pt;
            font-weight: bold;
            font-style: italic;
            margin: 2px 0;
        }

        .skpi-number {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 10px;
        }

        .skpi-desc {
            text-align: center;
            font-size: 9pt;
            margin-bottom: 20px;
            padding: 0 10%;
        }

        /* --- Sections & Tables --- */
        .section-box {
            border: 1px solid #000;
            padding: 5px;
            margin-bottom: 15px;
        }
        
        /* PDF asli tidak pakai kotak border per section, tapi spacing headers */
        .section-header {
            font-weight: bold;
            font-size: 11pt;
            margin-top: 15px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        table.info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }

        table.info-table td {
            vertical-align: top;
            padding: 2px 0;
        }

        /* Kolom Penomoran (1.1, 1.2) */
        .col-num { width: 30px; font-weight: bold; }
        /* Kolom Label */
        .col-label { width: 220px; }
        /* Kolom Titik Dua */
        .col-sep { width: 15px; text-align: center; }
        /* Kolom Isi */
        .col-val { font-weight: bold; }

        /* --- Section 3.2 Two Columns --- */
        .split-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .split-table td {
            width: 50%;
            vertical-align: top;
            padding: 0 10px;
            border: 1px solid #000; /* PDF Section 3.2 often has borders or strictly separated */
        }
        
        /* Modifikasi agar mirip PDF: Borderless outer, content lists */
        .two-col-container {
            width: 100%;
            display: table;
        }
        .col-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 10px;
            border-right: 1px solid #ccc;
        }
        .col-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-left: 10px;
        }

        /* --- Lists --- */
        ol.custom-list {
            padding-left: 20px;
            margin: 0;
            list-style-type: lower-alpha;
        }
        ol.custom-list li {
            margin-bottom: 3px;
            padding-left: 5px;
        }

        /* --- Footer --- */
        .footer-signature {
            margin-top: 30px;
            width: 100%;
        }
        .sign-box {
            float: right;
            width: 40%;
            text-align: left; /* PDF aligns signature text left usually, but standard is center of box */
        }

    </style>
</head>

<body>
    @php
        use Carbon\Carbon;
        use App\Models\Curriculum;
        // Gunakan locale Indonesia
        Carbon::setLocale('id');

        // Helper date
        $dateLulus = $user->tanggal_lulus ? Carbon::parse($user->tanggal_lulus)->translatedFormat('d F Y') : '-';
        $dateLahir = $user->tanggal_lahir ? Carbon::parse($user->tanggal_lahir)->translatedFormat('d F Y') : '-';
        $dateNow = Carbon::now()->translatedFormat('d F Y');

        // CPL dari kurikulum aktif prodi (fallback: kurikulum aktif terbaru)
        $curriculum = Curriculum::with('cplItems')
            ->where('is_active', true)
            ->when($user->prodi_id, fn($q) => $q->where('prodi_id', $user->prodi_id))
            ->latest('year')
            ->first();
        $cplItems = $curriculum?->cplItems ?? collect();
        $cpl = $cplItems->groupBy('category');

        // Kelompok portofolio terverifikasi per kategori
        $verifiedPortfolios = $verifiedPortfolios ?? collect();
        $groupPortfolio = [
            'prestasi' => $verifiedPortfolios->filter(fn($p) => str_contains(strtolower($p->kategori_portfolio ?? ''), 'prestasi')),
            'organisasi' => $verifiedPortfolios->filter(fn($p) => str_contains(strtolower($p->kategori_portfolio ?? ''), 'organisasi')),
            'magang' => $verifiedPortfolios->filter(fn($p) => str_contains(strtolower($p->kategori_portfolio ?? ''), 'magang')),
        ];

        // Pejabat penandatangan
        $signaturePath = (isset($official) && $official?->signature_path) ? public_path('storage/'.$official->signature_path) : null;
        $officialName = $official->display_name ?? 'Faisal Hadi, ST, M.T';
        $officialNip = $official->nip ?? '197707132002121005';
        $officialRole = $official->jabatan ?? 'Dekan Fakultas Teknik';
    @endphp

    <div class="header">
        <div class="faculty">FAKULTAS TEKNIK</div>
        <div class="univ">UNIVERSITAS BENGKULU</div>
    </div>

    <div class="skpi-title">
        <h1>SURAT KETERANGAN PENDAMPING IJAZAH</h1>
        <h2>DIPLOMA SUPPLEMENT</h2>
    </div>
    <div class="skpi-number">
        Nomor: {{ $user->nomor_skpi ?? '.......................' }}
    </div>

    <div class="skpi-desc">
        Surat Keterangan Pendamping Ijazah sebagai pelengkap Ijazah yang menerangkan capaian pembelajaran dan prestasi dari pemegang Ijazah selama studi<br>
        <span class="en">The Diploma Supplement accompanies a higher education certificate providing a standardized description of the nature, level, content and status of studies completed by its holder</span>
    </div>

    <div class="section-header">
        1. INFORMASI TENTANG IDENTITAS DIRI PEMEGANG SKPI<br>
        <span class="en" style="font-weight:normal; text-transform:none;">INFORMATION OF PERSONAL IDENTITY DIPLOMA SUPPLEMENT HOLDER</span>
    </div>

    <table class="info-table">
        <tr>
            <td class="col-num">1.1</td>
            <td class="col-label">Nama Lengkap<span class="en">Name</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ strtoupper($user->name) }}</td>
        </tr>
        <tr>
            <td class="col-num">1.2</td>
            <td class="col-label">Tempat dan Tanggal Lahir<span class="en">Place and Date of Birth</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                {{ $user->tempat_lahir }}, {{ $dateLahir }}
                <span class="en" style="font-weight:bold">{{ $user->tempat_lahir }}, {{ $user->tanggal_lahir ? Carbon::parse($user->tanggal_lahir)->format('F d, Y') : '-' }}</span>
            </td>
        </tr>
        <tr>
            <td class="col-num">1.3</td>
            <td class="col-label">Nomor Induk Mahasiswa<span class="en">Student Identification Number</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ $user->nim }}</td>
        </tr>
        <tr>
            <td class="col-num">1.4</td>
            <td class="col-label">Tahun Masuk<span class="en">Admission Year</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ substr($user->nim, 3, 4) ?? '20..' }} </td>
        </tr>
        <tr>
            <td class="col-num">1.5</td>
            <td class="col-label">Tanggal Lulus<span class="en">Date of Graduation</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                {{ $dateLulus }}
                <span class="en" style="font-weight:bold">
                     {{ $user->tanggal_lulus ? Carbon::parse($user->tanggal_lulus)->format('F d, Y') : '-' }}
                </span>
            </td>
        </tr>
        <tr>
            <td class="col-num">1.6</td>
            <td class="col-label">Nomor Ijazah/Nomor Seri<span class="en">Certificate Number</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ $user->nomor_ijazah }}</td>
        </tr>
        <tr>
            <td class="col-num">1.7</td>
            <td class="col-label">Gelar<span class="en">Title</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                {{ $user->gelar_id ?? 'Sarjana Komputer (S.Kom)' }}
                <span class="en" style="font-weight:bold">{{ $user->gelar_en ?? 'Bachelor of Computer Science' }}</span>
            </td>
        </tr>
    </table>

    <br>

    <div class="section-header">
        2. INFORMASI TENTANG IDENTITAS PENYELENGGARA PROGRAM<br>
        <span class="en" style="font-weight:normal; text-transform:none;">INFORMATION OF IDENTITY HIGHER EDUCATION INSTITUTION</span>
    </div>

    <table class="info-table">
        <tr>
            <td class="col-num">2.1</td>
            <td class="col-label">Surat Keterangan Pendirian<span class="en">Certificate of Establishment</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                Keputusan Presiden RI Nomor 17 Tahun 1982
                <span class="en">Republic of Indonesia Presidential Instruction Number 17, 1982</span>
            </td>
        </tr>
        <tr>
            <td class="col-num">2.2</td>
            <td class="col-label">Nama Perguruan Tinggi<span class="en">Name of University</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                Universitas Bengkulu
                <span class="en">Bengkulu University</span>
            </td>
        </tr>
        <tr>
            <td class="col-num">2.3</td>
            <td class="col-label">Fakultas<span class="en">Faculty</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                Teknik
                <span class="en">Engineering</span>
            </td>
        </tr>
        <tr>
            <td class="col-num">2.4</td>
            <td class="col-label">Nama Program Studi<span class="en">Study Program</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                {{ $user->prodi->nama_prodi ?? 'Sistem Informasi' }}
                <span class="en">{{ $user->prodi->nama_en ?? 'Information Systems' }}</span>
            </td>
        </tr>
        <tr>
            <td class="col-num">2.5</td>
            <td class="col-label">Jenis Pendidikan<span class="en">Classification of Study</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                Akademik
                <span class="en">Academic</span>
            </td>
        </tr>
        <tr>
            <td class="col-num">2.6</td>
            <td class="col-label">Jenjang Pendidikan<span class="en">Education Level</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                Strata 1 (S-1)
                <span class="en">Bachelor Degree</span>
            </td>
        </tr>
        <tr>
            <td class="col-num">2.7</td>
            <td class="col-label">Jenjang Kualifikasi Sesuai KKNI<span class="en">Qualification Level of KKNI</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                Level 6
                <span class="en">Level 6</span>
            </td>
        </tr>
        <tr>
            <td class="col-num">2.8</td>
            <td class="col-label">Persyaratan Penerimaan<span class="en">Admission Requirements</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                Lulus Pendidikan Menengah Atas atau Sederajat
                <span class="en">Graduated From High School Or Similar Level Of Education</span>
            </td>
        </tr>
        <tr>
            <td class="col-num">2.9</td>
            <td class="col-label">Bahasa Pengantar Kuliah<span class="en">Medium of Instruction in Lecture</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                Bahasa Indonesia
                <span class="en">Indonesian</span>
            </td>
        </tr>
        <tr>
            <td class="col-num">2.10</td>
            <td class="col-label">Sistem Penilaian<span class="en">Evaluation System</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                Skala 1-4; A: 4.00, A-:3.75, B+: 3.50, B: 3.00, B-: 2.75, C+: 2.50, C: 2.00, D: 1.00, E: 0
            </td>
        </tr>
        <tr>
            <td class="col-num">2.11</td>
            <td class="col-label">Lama Studi Reguler<span class="en">Regular Study Period</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                8 Semester
                <span class="en">8 Semesters</span>
            </td>
        </tr>
        <tr>
            <td class="col-num">2.12</td>
            <td class="col-label">Jenis dan Jenjang Pendidikan Lanjutan<span class="en">Access to Further Study</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                Program Magister dan Doktoral
                <span class="en">Master and Doctoral Program</span>
            </td>
        </tr>
         <tr>
            <td class="col-num">2.13</td>
            <td class="col-label">Status Profesi<span class="en">Professional Status</span></td>
            <td class="col-sep">:</td>
            <td class="col-val">
                -
            </td>
        </tr>
    </table>
    
    <div style="page-break-after: always;"></div>

    <div class="section-header">
        3. INFORMASI TENTANG KUALIFIKASI DAN HASIL YANG DICAPAI<br>
        <span class="en" style="font-weight:normal; text-transform:none;">INFORMATION OF QUALIFICATION AND LEARNING OUTCOME</span>
    </div>

    <div style="margin-left: 30px; margin-bottom: 10px; font-weight: bold;">
        3.1 Capaian Pembelajaran <span class="en" style="display:inline; font-weight:normal;">/ Learning Outcomes</span>
    </div>

    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td width="50%" style="font-weight:bold; text-align:center; border-bottom:1px solid #000;">Bahasa Indonesia</td>
            <td width="50%" style="font-weight:bold; text-align:center; border-bottom:1px solid #000;" class="en">English</td>
        </tr>
        
        @php
            $cplCategories = [
                'sikap' => ['Sikap', 'Attitude'],
                'kerja' => ['Kemampuan di Bidang Kerja', 'Ability in The Field of Work'],
                'pengetahuan' => ['Pengetahuan yang Dikuasai', 'Ability of Knowledge'],
                'umum' => ['Kemampuan Umum', 'General Skills'],
            ];
            // Simulasi data CPL jika variabel $cpl tidak tersedia dari controller
            $cpl = $cpl ?? collect(); 
        @endphp

        @foreach($cplCategories as $catKey => $titles)
        <tr>
            <td style="font-weight:bold; padding-top:10px;">{{ $titles[0] }}</td>
            <td style="font-weight:bold; padding-top:10px;" class="en">{{ $titles[1] }}</td>
        </tr>
        <tr>
            <td style="vertical-align:top;">
                <ol class="custom-list">
                    @php $items = $cpl[$catKey] ?? collect(); @endphp
                    @forelse($items as $item)
                        <li>{{ $item->desc_id }}</li>
                    @empty
                        <li>-</li>
                    @endforelse
                </ol>
            </td>
            <td style="vertical-align:top;">
                <ol class="custom-list">
                    @forelse($items as $item)
                        <li class="en">{{ $item->desc_en }}</li>
                    @empty
                        <li class="en">-</li>
                    @endforelse
                </ol>
            </td>
        </tr>
        @endforeach
    </table>

    <div style="page-break-after: always;"></div>

    <div style="margin-left: 0px; margin-bottom: 10px; font-weight: bold;">
        3.2 Informasi Tambahan <span class="en" style="display:inline; font-weight:normal;">/ Additional Information</span>
    </div>

    <table class="split-table" border="1">
        <thead>
            <tr>
                <th style="padding:5px; background:#f0f0f0;">Bahasa Indonesia</th>
                <th style="padding:5px; background:#f0f0f0;" class="en">English</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="vertical-align:top; padding:10px;">
                    <strong>Penghargaan dan Pemenang Kejuaraan</strong>
                    <ol class="custom-list">
                        @forelse($groupPortfolio['prestasi'] as $p)
                            <li>{{ $p->nama_dokumen_id ?? $p->judul_kegiatan }}</li>
                        @empty
                            <li>-</li>
                        @endforelse
                    </ol>
                    
                    <br>
                    <strong>Pengalaman Organisasi</strong>
                    <ol class="custom-list">
                        @forelse($groupPortfolio['organisasi'] as $p)
                            <li>{{ $p->nama_dokumen_id ?? $p->judul_kegiatan }}</li>
                        @empty
                            <li>-</li>
                        @endforelse
                    </ol>

                    <br>
                    <strong>Spesifikasi Tugas Akhir</strong>
                    <div style="padding-left:20px;">
                        {{ $user->tugas_akhir_id ?? '-' }}
                    </div>

                     <br>
                    <strong>Magang Industri</strong>
                     <ol class="custom-list">
                        @forelse($groupPortfolio['magang'] as $p)
                            <li>{{ $p->nama_dokumen_id ?? $p->judul_kegiatan }}</li>
                        @empty
                            <li>-</li>
                        @endforelse
                    </ol>
                </td>

                <td style="vertical-align:top; padding:10px;">
                    <strong class="en">Certificate of Honors and Awards</strong>
                    <ol class="custom-list">
                        @forelse($groupPortfolio['prestasi'] as $p)
                            <li class="en">{{ $p->nama_dokumen_en ?? $p->nama_dokumen_id ?? $p->judul_kegiatan }}</li>
                        @empty
                            <li class="en">-</li>
                        @endforelse
                    </ol>

                    <br>
                    <strong class="en">Organizational Experiences</strong>
                    <ol class="custom-list">
                        @forelse($groupPortfolio['organisasi'] as $p)
                            <li class="en">{{ $p->nama_dokumen_en ?? $p->nama_dokumen_id ?? $p->judul_kegiatan }}</li>
                        @empty
                            <li class="en">-</li>
                        @endforelse
                    </ol>

                    <br>
                    <strong class="en">Specification of The Final Project</strong>
                    <div style="padding-left:20px;" class="en">
                        {{ $user->tugas_akhir_en ?? ($user->tugas_akhir_id ?? '-') }}
                    </div>
                    
                    <br>
                    <strong class="en">Internship</strong>
                     <ol class="custom-list">
                        @forelse($groupPortfolio['magang'] as $p)
                            <li class="en">{{ $p->nama_dokumen_en ?? $p->nama_dokumen_id ?? $p->judul_kegiatan }}</li>
                        @empty
                            <li class="en">-</li>
                        @endforelse
                    </ol>
                </td>
            </tr>
        </tbody>
    </table>

    <br>

    <div class="footer-signature">
        <div class="sign-box">
            Bengkulu, {{ $dateNow }}<br>
            {{ $officialRole }}<br>
            @if($signaturePath)
                <img src="{{ $signaturePath }}" alt="Tanda tangan" style="height:70px; margin:12px 0 4px 0;">
            @else
                <br><br><br><br>
            @endif
            <span style="font-weight:bold; text-decoration:underline;">{{ $officialName }}</span><br>
            NIP. {{ $officialNip }}
        </div>
        <div style="clear:both;"></div>
    </div>

</body>
</html>
