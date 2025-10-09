# SKPI FT UNIB

Projek ini adalah aplikasi **Surat Keterangan Pendamping Ijazah (SKPI)** untuk Fakultas Teknik Universitas Bengkulu (UNIB). Aplikasi ini dirancang untuk mempermudah proses pengumpulan, verifikasi, dan pencetakan SKPI bagi mahasiswa secara digital.

---

## 🎯 Fitur Utama

* Registrasi dan login mahasiswa, verifikator, serta admin fakultas.
* Upload dan manajemen portofolio mahasiswa (prestasi, organisasi, magang, pelatihan, sertifikat).
* Verifikasi data oleh verifikator fakultas.
* Pembuatan dan pencetakan SKPI otomatis dalam format PDF bilingual (Indonesia–Inggris).
* Dashboard interaktif dengan statistik dan status verifikasi.

---

## ⚙️ Teknologi yang Digunakan

| Komponen          | Teknologi                        |
| ----------------- | -------------------------------- |
| Framework Backend | Laravel 12 + Livewire            |
| Frontend          | Blade + Tailwind CSS + Vite      |
| Database          | MySQL                            |
| Autentikasi       | Laravel Breeze                   |
| PDF Generator     | DomPDF + DejaVu Sans Font        |

---

## 🚀 Cara Instalasi (Localhost)

### 1. Clone Repositori

```bash
git clone https://github.com/Srjeff27/skpi-ft-unib.git
cd skpi-ft-unib
```

### 2. Instal Dependensi

```bash
composer install
npm install
```

### 3. Konfigurasi File Environment

Salin file contoh dan ubah pengaturannya:

```bash
cp .env.example .env
```

Edit file `.env` sesuai kebutuhan:

```
APP_NAME="SKPI FT UNIB"
APP_URL=http://localhost:8000
DB_DATABASE=skpi_ft_unib
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Key Aplikasi

```bash
php artisan key:generate
```

### 5. Migrasi dan Seeder Database

```bash
php artisan migrate --seed
```

### 6. Jalankan Server Laravel

```bash
php artisan serve
```

Akses di: **[http://localhost:8000](http://localhost:8000)**

### 7. Jalankan Vite (Frontend)

```bash
npm run dev
```

---

## 🧱 Struktur Folder Utama

```
skpi-ft-unib/
├── app/
│   ├── Http/
│   ├── Models/
│   └── Services/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
│   └── web.php
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
└── README.md
```

---

## 🧩 Role Pengguna

| Role           | Deskripsi                                           |
| -------------- | --------------------------------------------------- |
| Mahasiswa      | Mengisi dan mengunggah portofolio SKPI              |
| Verifikator    | Memeriksa dan memvalidasi data mahasiswa            |
| Admin Fakultas | Mengelola sistem, pengguna, dan mencetak SKPI final |

---

## 🤝 Kontribusi

1. Fork repositori ini
2. Buat branch baru: `git checkout -b fitur-nama`
3. Commit perubahan: `git commit -m "Tambah fitur X"`
4. Push ke branch: `git push origin fitur-nama`
5. Buat Pull Request

---

## 🪪 Lisensi

Proyek ini dilisensikan di bawah **MIT License**.

---

> *"Digitalisasi SKPI bukan hanya tentang efisiensi, tapi juga bukti bahwa inovasi mahasiswa teknik dapat memberi dampak nyata untuk kampus."*
