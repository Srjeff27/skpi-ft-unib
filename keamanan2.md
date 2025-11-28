# Laporan Implementasi Keamanan (Tindak Lanjut)

Ringkasan penerapan untuk poin 2–5.

## 2) Kontrol hapus & alur upload
- **Authorize hapus portofolio**: now enforced via policy di `app/Http/Controllers/Verifikator/PortfolioReviewController.php` (`$this->authorize('delete', $portfolio)`).
- **Upload divalidasi & disimpan privat**:
  - Form request `app/Http/Requests/Student/StorePortfolioRequest.php` dan `UpdatePortfolioRequest.php` mewajibkan salah satu: URL atau file; file dibatasi `pdf/jpg/jpeg/png`, max 5MB.
  - `PortfolioService` menyimpan file ke disk `local` (private) dan menyimpan path, bukan URL publik.
  - Bukti diakses via controller terproteksi `app/Http/Controllers/PortfolioEvidenceController.php` + route `portfolios.proof` dengan authorize view; semua tampilan portofolio mengarah ke route ini jika file privat.

## 3) Pembaruan dependensi rentan
- Composer upgrade: `dompdf/dompdf` → 2.0.8, `phenx/php-svg-lib` → 0.5.4, `symfony/http-foundation` → 7.3.7 (lihat `composer.lock`).
- `composer audit --format=summary` hasil: tidak ada advisori.

## 4) Rate limiting & password policy
- **Rate limit login**: limiter `login` (5/menit per IP & email) didefinisikan di `AppServiceProvider` dan diterapkan pada rute login admin/verifikator (`routes/auth.php`). Mahasiswa sudah dibatasi via `LoginRequest`.
- **Password reset/import lebih kuat**:
  - Reset admin: password random 16 karakter, dilog (`Admin\UserController::resetPassword`).
  - Import CSV: role di-whitelist, password acak 16 chars bila kosong/lemah (<12), dihitung dan dilog (`Admin\ImportController@importUsers`).

## 5) Logging & monitoring
- Aktivitas sensitif kini dilog melalui `ActivityLogger` untuk: reset password admin, import user (jumlah & password digenerate), update pengaturan institusi/narasi/umum (`SystemSettingsController`).
- Masih perlu: hook log untuk login gagal/berhasil admin & verifikator, alarm/alert (email/SIEM), dan review log berkala; tidak ditambahkan karena di luar cakupan cepat ini.
