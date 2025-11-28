# Keunggulan Sistem SKPI FT UNIB

## Penggunaan (User Experience & Operasional)
- **Alur peran tersegmentasi**: Mahasiswa, verifikator, dan admin memiliki dashboard serta fungsi sesuai peran (pengajuan portofolio, review, laporan) sehingga proses tidak saling tumpang-tindih.
- **Pengajuan portofolio terarah**: Form validasi wajib/opsional, kategori tersusun, unggah bukti via link atau file, dan status portofolio transparan (pending/verified/rejected) dengan notifikasi.
- **Verifikasi terstruktur**: Verifikator memfilter berdasarkan prodi/angkatan/status; persetujuan, tolak, atau minta revisi dengan catatan; admin punya laporan CSV/PDF dan cetak SKPI.
- **SKPI digital & verifikasi publik**: SKPI ber-QR dan signed URL untuk verifikasi pihak ketiga, mendukung validasi dokumen secara praktis.
- **Integrasi Google Sign-In**: Mempercepat onboarding mahasiswa yang memakai akun kampus.
- **Antarmuka modern & responsif**: Layout berbasis Tailwind/Alpine, komponen konsisten (modal, toast, input error), mendukung desktop-mobile, dan feedback visual jelas.

## Keamanan (Control & Proteksi)
- **Kontrol akses berbasis peran & kebijakan**: Middleware role + policy untuk portofolio (view/update/delete) menjaga data tetap di prodi/role yang benar; admin-only untuk pengaturan & laporan.
- **Proteksi brute force**: Rate limiting login (per IP & email) dan layar lockout penuh saat throttle aktif, memblokir interaksi sampai masa tunggu selesai.
- **Hardening autentikasi**: Password reset/import memakai password acak kuat; login admin/verifikator dipisah; session driver terenkripsi (disarankan) dan email verifikasi untuk mahasiswa.
- **Validasi & isolasi bukti**: Bukti portofolio tervalidasi (url atau file terbatas tipe/ukuran) dan file disimpan privat lalu disajikan via route terproteksi, mencegah akses publik langsung.
- **Logging aktivitas sensitif**: Pencatatan reset password, import user, perubahan pengaturan, dan aksi verifikator/admin untuk audit jejak perubahan.
- **Ketahanan komponen**: Dependensi rentan (dompdf/php-svg-lib/http-foundation) telah diperbarui; konfigurasi maintenance/portfolio window ada kontrol admin; rekomendasi prod: debug off, least-privilege DB, storage privat.
