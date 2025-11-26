<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Pendamping Ijazah (SKPI) - {{ $user->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 1.6cm;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            color: #000;
            line-height: 1.35;
            background: #fff;
        }

        .en {
            font-style: italic;
            color: #333;
            font-weight: 400;
        }

        .page {
            position: relative;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .header img {
            height: 85px;
            margin-bottom: 6px;
        }

        .header .faculty {
            font-size: 14pt;
            font-weight: 700;
            text-transform: uppercase;
        }

        .header .university {
            font-size: 13pt;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .doc-title {
            text-align: center;
            margin-top: 8px;
            margin-bottom: 8px;
        }

        .doc-title .id {
            font-size: 15pt;
            font-weight: 700;
            text-transform: uppercase;
        }

        .doc-title .en {
            display: block;
            font-size: 13pt;
        }

        .doc-number {
            text-align: center;
            margin-bottom: 12px;
            font-size: 10pt;
        }

        .doc-desc {
            text-align: center;
            margin-bottom: 12px;
            font-size: 10pt;
        }

        /* Section titles */
        .section-title {
            font-weight: 700;
            margin-top: 12px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .section-title .en {
            font-weight: 600;
            display: block;
            text-transform: none;
        }

        /* Info table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 3px 4px;
            vertical-align: top;
        }

        .info-table .no {
            width: 35px;
        }

        .info-table .label {
            width: 240px;
            font-weight: 600;
        }

        .info-table .sep {
            width: 10px;
        }

        /* Dual column blocks */
        .dual-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .dual-table th {
            text-align: center;
            font-weight: 700;
            padding: 6px 0;
            border-bottom: 1px solid #000;
        }

        .dual-table td {
            vertical-align: top;
            padding: 8px 10px;
            width: 50%;
        }

        .cpl-heading {
            font-weight: 700;
            margin-bottom: 4px;
        }

        .cpl-list {
            margin: 0 0 8px 16px;
            padding: 0;
        }

        .cpl-list li {
            margin-bottom: 6px;
        }

        /* Additional info */
        .sub-title {
            font-weight: 700;
            margin-top: 10px;
            margin-bottom: 6px;
        }

        /* Signature */
        .signature {
            width: 100%;
            margin-top: 24px;
        }

        .signature td {
            width: 100%;
            text-align: right;
            padding-top: 10px;
        }

        .sig-name {
            font-weight: 700;
            text-decoration: underline;
            text-decoration-thickness: 1px;
            text-underline-offset: 2px;
        }

        .qr {
            margin-top: 6px;
        }

        .qr img {
            width: 85px;
            height: 85px;
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

        Carbon::setLocale('id');

        $formatDate = function ($date, string $locale = 'id') {
            if (!$date) {
                return null;
            }
            $c = Carbon::parse($date)->locale($locale);
            return $locale === 'id' ? $c->translatedFormat('d F Y') : $c->translatedFormat('F j, Y');
        };

        $achievements = $verifiedPortfolios ?? collect();
        $organizationPortfolios = $achievements->filter(
            fn($p) => str_contains(strtolower($p->kategori_portfolio ?? ''), 'organisasi')
        );
        $internshipPortfolios = $achievements->filter(
            fn($p) => str_contains(strtolower($p->kategori_portfolio ?? ''), 'magang') ||
                str_contains(strtolower($p->kategori_portfolio ?? ''), 'intern')
        );

        $finalProjectId = $user->tugas_akhir_id ?? null;
        $finalProjectEn = $user->tugas_akhir_en ?? null;

        $birthDateId = $formatDate($user->tanggal_lahir, 'id');
        $birthDateEn = $formatDate($user->tanggal_lahir, 'en');
        $gradDateId = $formatDate($user->tanggal_lulus, 'id');
        $gradDateEn = $formatDate($user->tanggal_lulus, 'en');
        $issueDateId = $formatDate($fin?->locked_at ?? $user->tanggal_lulus ?? now(), 'id');

        $admissionYear = $user->angkatan ?? null;
        $diplomaNumbers = array_values(
            array_filter([
                $user->nomor_ijazah ?? null,
                $user->nomor_seri_ijazah ?? null,
                $user->nomor_seri ?? null,
            ])
        );

        $programName = optional($user->prodi)->nama_prodi;
        $programLevel = strtoupper(optional($user->prodi)->jenjang ?? '');
        $educationLevelId = match ($programLevel) {
            'S1' => 'Strata S-1',
            'S2' => 'Strata S-2',
            'S3' => 'Strata S-3',
            'D3' => 'Diploma III',
            default => ($programLevel ? 'Strata ' . $programLevel : '-'),
        };
        $educationLevelEn = match ($programLevel) {
            'S1' => 'Bachelor Degree',
            'S2' => 'Master Degree',
            'S3' => 'Doctoral Degree',
            'D3' => 'Diploma Three',
            default => ($programLevel ? $programLevel : '-'),
        };
        $kkniLevel = match ($programLevel) {
            'S1' => 'Level 6',
            'S2' => 'Level 8',
            'S3' => 'Level 9',
            'D3' => 'Level 5',
            default => '-',
        };
        $regularSemester = match ($programLevel) {
            'S1' => 8,
            'S2' => 4,
            'S3' => 6,
            'D3' => 6,
            default => null,
        };
        $studyPeriodId = $regularSemester ? $regularSemester . ' Semester' : '-';
        $studyPeriodEn = $regularSemester ? $regularSemester . ' Semesters' : '-';

        $studyClassification = Setting::get('study_classification', 'Akademik');
        $studyClassificationEn = $studyClassification === 'Profesi' ? 'Professional' : 'Academic';
        $nextStudy = Setting::get('further_study', 'Program Magister dan Doktoral');
        $nextStudyEn = Setting::get('further_study_en', 'Master and Doctoral Program');
        $professionalStatus = Setting::get('professional_status', '-');
        $gradingText =
            $grading ??
            'Skala 1.4; 4.00 A; 3.75 B+; 3.50 B; 3.00 B-; 2.75 C+; 2.50 C; 2.00 D; 1.00 E';
        $admissionRequirement =
            $admission ?? 'Lulus Pendidikan Menengah Atas atau Sederajat / Graduated From High School';
        $languageOfInstruction = $languages ?: 'Bahasa Indonesia';

        $cplCategories = [
            'sikap' => ['id' => 'Sikap', 'en' => 'Attitude'],
            'khusus' => ['id' => 'Kemampuan di Bidang Kerja', 'en' => 'Ability In The Field Of Work'],
            'pengetahuan' => ['id' => 'Pengetahuan yang Dikuasai', 'en' => 'Ability Of Knowledge'],
            'umum' => ['id' => 'Kemampuan Umum', 'en' => 'General Skills'],
        ];
    @endphp

    <div class="page">
        <header class="header">
            @if ($logoPath && is_file(storage_path('app/public/' . $logoPath)))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $logoPath))) }}"
                    alt="Logo">
            @endif
            <div class="faculty">{{ $faculty }}</div>
            <div class="university">{{ $univ }}</div>
        </header>

        <div class="doc-title">
            <span class="id">Surat Keterangan Pendamping Ijazah</span>
            <span class="en">Diploma Supplement</span>
        </div>
        <div class="doc-number">Nomor : {{ $user->nomor_skpi ?? '-' }}</div>
        <div class="doc-desc">
            Surat Keterangan Pendamping Ijazah sebagai pelengkap ijazah yang menerangkan capaian pembelajaran dan
            prestasi dari pemegang Ijazah selama studi<br>
            <span class="en">The Diploma Supplement accompanies a higher education certificate providing a standardized
                description of the nature, level, content and status of studies completed by its holder</span>
        </div>

        <div class="section-title">
            I. INFORMASI TENTANG IDENTITAS DIRI PEMEGANG SKPI
            <span class="en">Information of Personal Identity Diploma Supplement Holder</span>
        </div>
        <table class="info-table">
            <tr>
                <td class="no">1.1</td>
                <td class="label">NAMA<br><span class="en">Name</span></td>
                <td class="sep">:</td>
                <td class="value"><strong>{{ strtoupper($user->name ?? '-') }}</strong></td>
            </tr>
            <tr>
                <td class="no">1.2</td>
                <td class="label">Tempat dan Tanggal Lahir<br><span class="en">Place and Date of Birth</span></td>
                <td class="sep">:</td>
                <td class="value">
                    {{ $user->tempat_lahir ? ucwords($user->tempat_lahir) : '-' }}{{ $birthDateId ? ', ' . $birthDateId : '' }}<br>
                    <span class="en">{{ $user->tempat_lahir ? ucwords($user->tempat_lahir) : '-' }}{{ $birthDateEn ? ', ' . $birthDateEn : '' }}</span>
                </td>
            </tr>
            <tr>
                <td class="no">1.3</td>
                <td class="label">Nomor Induk Mahasiswa<br><span class="en">Student Identification Number</span></td>
                <td class="sep">:</td>
                <td class="value">{{ $user->nim ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no">1.4</td>
                <td class="label">Tahun Masuk<br><span class="en">Admission Year</span></td>
                <td class="sep">:</td>
                <td class="value">{{ $admissionYear ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no">1.5</td>
                <td class="label">Tanggal Lulus<br><span class="en">Date of Graduation</span></td>
                <td class="sep">:</td>
                <td class="value">
                    {{ $gradDateId ?? '-' }}<br>
                    <span class="en">{{ $gradDateEn ?? '-' }}</span>
                </td>
            </tr>
            <tr>
                <td class="no">1.6</td>
                <td class="label">Nomor Ijazah/Nomor Seri<br><span class="en">Certificate Number</span></td>
                <td class="sep">:</td>
                <td class="value">
                    @if (count($diplomaNumbers))
                        @foreach ($diplomaNumbers as $num)
                            {{ $num }}<br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="no">1.7</td>
                <td class="label">Gelar<br><span class="en">Title</span></td>
                <td class="sep">:</td>
                <td class="value">
                    {{ $user->gelar_id ?? '-' }}<br>
                    <span class="en">{{ $user->gelar_en ?? ($user->gelar_id ?? '-') }}</span>
                </td>
            </tr>
        </table>

        <div class="section-title" style="margin-top:14px;">
            II. INFORMASI TENTANG IDENTITAS PENYELENGGARA PROGRAM
            <span class="en">Information Of Identity Higher Education Institution</span>
        </div>
        <table class="info-table">
            <tr>
                <td class="no">2.1</td>
                <td class="label">Surat Keterangan Pendirian<br><span class="en">Certificate of Establishment</span></td>
                <td class="sep">:</td>
                <td class="value">{{ $skpt ?: 'Keputusan Presiden RI' }}</td>
            </tr>
            <tr>
                <td class="no">2.2</td>
                <td class="label">Nama Perguruan Tinggi<br><span class="en">Name of University</span></td>
                <td class="sep">:</td>
                <td class="value">{{ $univ }}</td>
            </tr>
            <tr>
                <td class="no">2.3</td>
                <td class="label">Fakultas<br><span class="en">Faculty</span></td>
                <td class="sep">:</td>
                <td class="value">{{ $faculty }}</td>
            </tr>
            <tr>
                <td class="no">2.4</td>
                <td class="label">Nama Program Studi<br><span class="en">Study Program</span></td>
                <td class="sep">:</td>
                <td class="value">{{ $programName ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no">2.5</td>
                <td class="label">Jenis Pendidikan<br><span class="en">Classification of Study</span></td>
                <td class="sep">:</td>
                <td class="value">{{ $studyClassification }}<br><span class="en">{{ $studyClassificationEn }}</span></td>
            </tr>
            <tr>
                <td class="no">2.6</td>
                <td class="label">Jenjang Pendidikan<br><span class="en">Education Level</span></td>
                <td class="sep">:</td>
                <td class="value">{{ $educationLevelId }}<br><span class="en">{{ $educationLevelEn }}</span></td>
            </tr>
            <tr>
                <td class="no">2.7</td>
                <td class="label">Jenjang Kualifikasi Sesuai KKNI<br><span class="en">Qualification Level of KKNI</span></td>
                <td class="sep">:</td>
                <td class="value">{{ $kkniLevel }}</td>
            </tr>
            <tr>
                <td class="no">2.8</td>
                <td class="label">Persyaratan Penerimaan<br><span class="en">Admission Requirements</span></td>
                <td class="sep">:</td>
                <td class="value">{!! nl2br(e($admissionRequirement)) !!}</td>
            </tr>
            <tr>
                <td class="no">2.9</td>
                <td class="label">Bahasa Pengantar Kuliah<br><span class="en">Medium of Instruction in Lecture</span></td>
                <td class="sep">:</td>
                <td class="value">{{ $languageOfInstruction }}</td>
            </tr>
            <tr>
                <td class="no">2.10</td>
                <td class="label">Sistem Penilaian<br><span class="en">Evaluation System</span></td>
                <td class="sep">:</td>
                <td class="value">{!! nl2br(e($gradingText)) !!}</td>
            </tr>
            <tr>
                <td class="no">2.11</td>
                <td class="label">Lama Studi Reguler<br><span class="en">Regular Study Period</span></td>
                <td class="sep">:</td>
                <td class="value">{{ $studyPeriodId }}<br><span class="en">{{ $studyPeriodEn }}</span></td>
            </tr>
            <tr>
                <td class="no">2.12</td>
                <td class="label">Jenis dan Jenjang Pendidikan Lanjutan<br><span class="en">Access to Further Study</span></td>
                <td class="sep">:</td>
                <td class="value">{{ $nextStudy }}<br><span class="en">{{ $nextStudyEn }}</span></td>
            </tr>
            <tr>
                <td class="no">2.13</td>
                <td class="label">Status Profesi<br><span class="en">Professional Status</span></td>
                <td class="sep">:</td>
                <td class="value">{{ $professionalStatus }}</td>
            </tr>
        </table>

        <div class="section-title" style="margin-top:14px;">
            III. INFORMASI TENTANG KUALIFIKASI DAN HASIL YANG DICAPAI
            <span class="en">Information Of Qualification And Learning Outcome</span>
        </div>

        <div class="sub-title">3.1 Capaian Pembelajaran<br><span class="en">Learning Outcomes</span></div>
        <table class="dual-table">
            <thead>
                <tr>
                    <th>Bahasa Indonesia</th>
                    <th class="en">Bahasa Inggris</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @foreach ($cplCategories as $key => $label)
                            <div class="cpl-heading">{{ $label['id'] }}</div>
                            <ol class="cpl-list" type="a">
                                @forelse(($cpl[$key] ?? collect()) as $it)
                                    <li>{!! e($it->desc_id) !!}</li>
                                @empty
                                    <li>-</li>
                                @endforelse
                            </ol>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($cplCategories as $key => $label)
                            <div class="cpl-heading">{{ $label['en'] }}</div>
                            <ol class="cpl-list" type="a">
                                @forelse(($cpl[$key] ?? collect()) as $it)
                                    <li><span class="en" style="font-style: normal;">{!! e($it->desc_en ?: $it->desc_id) !!}</span></li>
                                @empty
                                    <li><span class="en">-</span></li>
                                @endforelse
                            </ol>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="sub-title">3.2 Informasi Tambahan<br><span class="en">Additional Information</span></div>
        <table class="dual-table">
            <thead>
                <tr>
                    <th>Bahasa Indonesia</th>
                    <th class="en">Bahasa Inggris</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="cpl-heading" style="text-align:center;">Penghargaan dan Pemenang Kejuaraan</div>
                        <ol class="cpl-list" type="a">
                            @forelse($achievements as $p)
                                <li>{{ $p->nama_dokumen_id ?? $p->judul_kegiatan }}</li>
                            @empty
                                <li>-</li>
                            @endforelse
                        </ol>

                        <div class="cpl-heading" style="text-align:center; margin-top:10px;">Pengalaman Organisasi</div>
                        <ol class="cpl-list" type="a">
                            @forelse($organizationPortfolios as $p)
                                <li>{{ $p->nama_dokumen_id ?? $p->judul_kegiatan }}</li>
                            @empty
                                <li>-</li>
                            @endforelse
                        </ol>

                        <div class="cpl-heading" style="text-align:center; margin-top:10px;">Spesifikasi Tugas Akhir</div>
                        <div>{{ $finalProjectId ?: '-' }}</div>

                        <div class="cpl-heading" style="text-align:center; margin-top:10px;">Bahasa Internasional</div>
                        <div>{{ $user->bahasa_internasional ?? '-' }}</div>

                        <div class="cpl-heading" style="text-align:center; margin-top:10px;">Magang / Industri</div>
                        <ol class="cpl-list" type="a">
                            @forelse($internshipPortfolios as $p)
                                <li>{{ $p->nama_dokumen_id ?? $p->judul_kegiatan }}</li>
                            @empty
                                <li>-</li>
                            @endforelse
                        </ol>

                        <div class="cpl-heading" style="text-align:center; margin-top:10px;">Pendidikan Karakter</div>
                        <div>{{ $user->pendidikan_karakter ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="cpl-heading" style="text-align:center;">Certificates of Honors and Awards</div>
                        <ol class="cpl-list" type="a">
                            @forelse($achievements as $p)
                                <li><span class="en" style="font-style: normal;">{{ $p->nama_dokumen_en ?? $p->judul_kegiatan }}</span></li>
                            @empty
                                <li><span class="en">-</span></li>
                            @endforelse
                        </ol>

                        <div class="cpl-heading" style="text-align:center; margin-top:10px;">Organizational Experiences</div>
                        <ol class="cpl-list" type="a">
                            @forelse($organizationPortfolios as $p)
                                <li><span class="en" style="font-style: normal;">{{ $p->nama_dokumen_en ?? $p->judul_kegiatan }}</span></li>
                            @empty
                                <li><span class="en">-</span></li>
                            @endforelse
                        </ol>

                        <div class="cpl-heading" style="text-align:center; margin-top:10px;">Specification of the Final Project</div>
                        <div><span class="en" style="font-style: normal;">{{ $finalProjectEn ?: ($finalProjectId ?: '-') }}</span></div>

                        <div class="cpl-heading" style="text-align:center; margin-top:10px;">International Language</div>
                        <div><span class="en" style="font-style: normal;">{{ $user->international_language ?? ($user->bahasa_internasional ?? '-') }}</span></div>

                        <div class="cpl-heading" style="text-align:center; margin-top:10px;">Internship</div>
                        <ol class="cpl-list" type="a">
                            @forelse($internshipPortfolios as $p)
                                <li><span class="en" style="font-style: normal;">{{ $p->nama_dokumen_en ?? $p->judul_kegiatan }}</span></li>
                            @empty
                                <li><span class="en">-</span></li>
                            @endforelse
                        </ol>

                        <div class="cpl-heading" style="text-align:center; margin-top:10px;">Soft Skill Training</div>
                        <div><span class="en" style="font-style: normal;">{{ $user->soft_skill_training ?? ($user->pendidikan_karakter ?? '-') }}</span></div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="signature">
            <tr>
                <td>
                    Bengkulu, {{ $issueDateId ?? Carbon::now()->translatedFormat('d F Y') }}<br>
                    {{ $official->jabatan ?? 'Dekan Fakultas Teknik' }}<br><br><br><br>
                    @if ($signatureSrc)
                        <img src="{{ $signatureSrc }}" alt="Signature" style="height:80px;"><br>
                    @endif
                    <span class="sig-name">{{ $official->display_name ?? '-' }}</span><br>
                    NIP: {{ $official->nip ?? '-' }}
                    @if (isset($qrBase64) && $qrBase64)
                        <div class="qr">
                            <img src="{{ $qrBase64 }}" alt="QR Code"><br>
                            <span class="en" style="font-size:9pt;">Verifikasi keaslian dokumen</span>
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
