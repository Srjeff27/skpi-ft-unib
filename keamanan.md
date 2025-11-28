# Laporan Uji Keamanan (OWASP Top 10)

Repo: aplikasi SKPI FT Unib (Laravel).

## A01: Broken Access Control
- **Verifikator dapat menghapus portofolio lintas prodi** – `app/Http/Controllers/Verifikator/PortfolioReviewController.php:109-127` tidak memanggil policy/authorize. Akibatnya verifikator cukup tahu `id` portofolio untuk menghapusnya meskipun bukan prodi yang sama (berbeda dengan approve/reject yang memanggil policy). Perbaiki dengan `$this->authorize('delete', $portfolio);` dan pastikan policy memeriksa prodi.

## A02: Cryptographic Failures
- **Session tidak dienkripsi** – contoh konfigurasi menggunakan `SESSION_DRIVER=database` dan `SESSION_ENCRYPT=false` sehingga data session (potensi PII/token CSRF) tersimpan plaintext di tabel `sessions`. Aktifkan `SESSION_ENCRYPT=true` atau gunakan driver cookie (terenkripsi) + pastikan kunci aplikasi kuat.

## A03: Injection
- Tidak ditemukan SQL/command injection pada review statis: input divalidasi dan query menggunakan Eloquent/binding. Tetap disarankan uji dinamis (SQLi, template injection) di endpoint kritikal setelah hardening lain selesai.

## A04: Insecure Design
- **Upload bukti portofolio tanpa validasi** – `StorePortfolioRequest`/`UpdatePortfolioRequest` tidak memvalidasi `bukti_file`, tetapi `PortfolioService` langsung menyimpan file ke disk publik dan membangun URL (`link_sertifikat`). Pengguna bisa mengunggah file berbahaya (HTML/JS/skrip) yang dapat diakses publik. Tambahkan validasi tipe/ukuran (`mimes:pdf,jpg,png`, batas ukuran), scan antivirus, dan simpan di storage privat lalu proxy melalui download terautentikasi.
- **Tautan SKPI bertanda tangan berlaku 5 tahun** – `Student\SkpiController` membuat signed URL dengan TTL sangat panjang. Jika tautan bocor, pihak lain dapat memverifikasi SKPI tanpa batas praktis. Pertimbangkan TTL lebih pendek + mekanisme revoke saat user dihapus/keluar.

## A05: Security Misconfiguration
- **Environment/dev exposure** – `docker-compose.yml` menjalankan `APP_ENV=local`, `APP_DEBUG=true`, database user root dengan password `root`, dan mengekspos MySQL 3306 serta phpMyAdmin 8080. Jika container dibuka ke internet, ini membuka kredensial dan stacktrace. Gunakan env produksi (debug off), akun DB least-privilege, dan batasi port/admin UI hanya dari jaringan internal/VPN.
- **APP_DEBUG pada .env.example** diset `true`; pastikan environment produksi menimpanya menjadi `false`.
- **Image produksi memasang dev dependencies** – `Dockerfile` memasang npm + dev packages dan menjalankan `npm run build || true` (gagal diam). Hilangkan dev tool di image rilis dan pastikan build gagal keras.

## A06: Vulnerable and Outdated Components
Hasil `composer audit`:
- `dompdf/dompdf v2.0.0` rentan RFI/URI validation/DoS (CVE-2023-23924, CVE-2023-50262, CVE-2022-41343). Upgrade ≥ 2.0.4.
- `phenx/php-svg-lib 0.4.1` rentan path traversal/RCE (GHSA-97m3-52wr-xvv2, CVE-2023-50251, CVE-2024-25117). Upgrade ≥ 0.5.2.
- `symfony/http-foundation v7.3.4` terdampak CVE-2025-64500 (PATH_INFO parsing bypass). Upgrade ≥ 7.3.7.
Hasil `npm audit`: tidak ada kerentanan ditemukan.

## A07: Identification and Authentication Failures
- **Brute force pada login admin/verifikator** – `Admin\Auth\AuthenticatedSessionController` dan `Verifikator\Auth\AuthenticatedSessionController` tidak memakai rate limiting seperti `LoginRequest` mahasiswa. Tambahkan rate limit (`RateLimiter`/`throttle:login`) dan CAPTCHA/lockout.
- **Reset/akun baru dengan password lemah statis** – `Admin\UserController::resetPassword` menetapkan `password123` yang diketahui publik; `Admin\ImportController` juga membuat user baru dengan password default yang sama bila kolom kosong. Gunakan password acak unik + kirim tautan reset atau paksa ganti password pada login pertama.
- **Akun Google tanpa verifikasi tambahan** – `Auth\GoogleController` membuat akun baru tanpa verifikasi email lokal atau batasan domain; batasi ke domain kampus dan lakukan binding manual agar tidak membuka pendaftaran liar.

## A08: Software and Data Integrity Failures
- **Import CSV tanpa kontrol integritas/role** – `Admin\ImportController` menerima file CSV apa pun, tidak memvalidasi nilai `role`, dan langsung `updateOrCreate` pengguna serta `firstOrCreate` prodi baru. CSV yang dimodifikasi dapat membuat akun admin/verifikator atau menimpa email tanpa jejak audit. Batasi nilai role (whitelist), tanda tangani/scan file import, tampilkan pratinjau sebelum commit, dan log seluruh operasi import.
- **Perubahan pengaturan sistem tidak tercatat** – `Admin\SystemSettingsController` menyimpan konfigurasi kritikal (maintenance window, logo, narasi) tanpa audit log. Tambahkan logging/approval flow untuk menjaga integritas konfigurasi.

## A09: Security Logging and Monitoring Failures
- Aktivitas penting tidak dicatat/di-alert: login gagal admin/verifikator, import CSV, perubahan pengaturan, dan reset password tidak tercatat di `ActivityLogger`. Tidak ada sentry/alerting untuk error atau percobaan serangan. Tambahkan logging berbasis event + notifikasi (email/SIEM) dan tetapkan retensi serta review berkala.

## A10: Server-Side Request Forgery (SSRF)
- **Dompdf mengizinkan fetch remote** – `Student\SkpiController` dan `Admin\ReportController` mengaktifkan `isRemoteEnabled` pada Dompdf. Dikombinasikan dengan kerentanan dompdf yang ada, input yang dapat dikendalikan (misal logo/teks yang mengizinkan URL) bisa memicu fetch ke host internal. Matikan `isRemoteEnabled` atau whitelist origin, serta perbarui dompdf/php-svg-lib ke versi aman.

## Langkah Lanjut Disarankan
1) Hardening akses port/container dan matikan debug di lingkungan produksi.  
2) Tambahkan authorize pada hapus portofolio dan perbaiki alur upload (validasi + storage privat).  
3) Perbarui dependensi PHP ke versi bebas CVE.  
4) Terapkan rate limiting + password policy kuat untuk semua alur login/reset/import.  
5) Perluas logging & alerting untuk operasi sensitif dan tinjau log secara berkala.
