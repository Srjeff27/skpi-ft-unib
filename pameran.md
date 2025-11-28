# Pameran & Uji Singkat

## Sorotan Keamanan yang Sudah Ada
- Autentikasi + verifikasi email untuk akses dashboard; grup route dibatasi `role:admin|verifikator|mahasiswa`.
- Kebijakan akses portofolio: admin bebas, verifikator hanya prodi sendiri, mahasiswa hanya miliknya.
- Rute verifikasi SKPI publik memakai Signed URL (`/verifikasi/skpi/{user}`) untuk mencegah manipulasi.
- Form request validasi input portofolio (judul, tanggal, URL sertifikat), CSRF aktif bawaan Laravel.
- Aktivitas penting dicatat lewat `ActivityLogger` dan notifikasi status portofolio dikirim ke user.

## Checklist Uji Manual (sebelum demo)
- Login tiap peran: admin, verifikator, mahasiswa; pastikan redirect dan menu sesuai.
- Authorization: coba akses `verifikator/portofolio/{id}` milik prodi lain (harus 403); mahasiswa coba akses portofolio user lain (403).
- SKPI Signed URL: buka link yang valid (harus tampil), ubah query/tanda tangan (harus 403/invalid).
- Form portofolio: input valid/invalid, uji batas panjang, URL sertifikat salah format, dan upload bukti (jika ada).
- Aksi verifikasi: approve/reject/request edit; cek status, catatan, dan notifikasi muncul.
- Filter & pencarian mahasiswa + portofolio: cari nama/NIM, filter angkatan; klik “Lihat Portofolio” hanya menampilkan milik mahasiswa itu.
- File terbuka aman: buka lampiran via link_sertifikat, pastikan tidak bisa unggah file berbahaya (lihat catatan peningkatan).

## Rekomendasi Penguatan Sebelum Klaim “Keamanan Tinggi”
- Validasi file bukti: batasi jenis (pdf/jpg/png), ukuran, dan scan virus jika memungkinkan; simpan di storage non-public lalu generate URL sementara.
- Pastikan produksi memakai HTTPS, `APP_DEBUG=false`, `SESSION_SECURE_COOKIE=true`, rate limit login.
- Audit log: tampilkan ringkasan log aktivitas verifikasi saat demo untuk menunjukkan jejak audit.
- Backup & pemantauan: siapkan log level `warning`, dan rotasi log.

## Alur Demo Singkat untuk Dekan/Dosen
- Tunjukkan 3 peran: (1) Mahasiswa upload portofolio + link sertifikat, status “Pending”. (2) Verifikator prodi membuka daftar mahasiswa, klik “Lihat Portofolio”, filter/cek dokumen, beri keputusan. (3) Admin bisa melihat lintas prodi dan cetak SKPI.
- Perlihatkan SKPI Signed URL untuk verifikasi eksternal tanpa login.
- Tampilkan notifikasi perubahan status dan catatan verifikator kepada mahasiswa.
- Tekankan guard keamanan: role-based menu, 403 saat akses lintas prodi, dan Signed URL.

## Catatan Operasional
- Sebelum demo: `php artisan config:cache && php artisan route:cache`, set `APP_URL`, `APP_ENV=production`, `APP_DEBUG=false`.
- Jika perlu data contoh, jalankan seeder/scrip uji lalu bersihkan setelahnya.

## Uji Keamanan Ringkas (OWASP Top 10)
- A01 Broken Access Control: Sudah ada middleware `role` dan policy portofolio per prodi/user; uji manual akses lintas peran/prodi → 403. Pastikan semua route sensitif berada dalam grup `auth` + `role`, dan Signed URL hanya untuk verifikasi SKPI.
- A02 Cryptographic Failures: Pastikan produksi pakai HTTPS, `SESSION_SECURE_COOKIE=true`, `APP_KEY` kuat; tidak menyimpan kredensial sensitif di DB/plain logs.
- A03 Injection: Input portofolio divalidasi; gunakan query builder/Eloquent (sudah dilakukan). Hindari raw query tanpa binding; lakukan fuzz test pada search (nama/NIM) dan catatan verifikator.
- A04 Insecure Design: Flow verifikator dibatasi per prodi; tambahkan pembatasan rate untuk login dan tindakan sensitif (bisa pakai Laravel rate limiter).
- A05 Security Misconfiguration: Matikan `APP_DEBUG`, cache config/route; pastikan permission storage/public aman. Matikan directory listing di webserver.
- A06 Vulnerable & Outdated Components: Jalankan `composer audit`/`npm audit` sebelum rilis; perbarui paket jika ada CVE.
- A07 Identification & Authentication Failures: Gunakan verifikasi email (sudah); pastikan sesi logout berfungsi, password reset aman, dan Google OAuth callback hanya menerima domain yang diizinkan (bila ada).
- A08 Software & Data Integrity Failures: Sign URL SKPI sudah ada; tambahkan checksum/validasi file upload dan gunakan disk non-public + temporary URL untuk bukti.
- A09 Security Logging & Monitoring Failures: `ActivityLogger` sudah mencatat; pastikan log akses gagal (403/401) tercatat, dan rotasi log aktif. Uji notifikasi anomali bila ada.
- A10 Server-Side Request Forgery: Pastikan tidak ada fetch URL arbitrer; untuk `link_sertifikat` hanya simpan string dan tampilkan sebagai link (jangan proxy); jika perlu fetch server-side, whitelist domain.
