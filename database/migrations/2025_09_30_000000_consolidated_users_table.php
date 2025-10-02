<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kita tidak membuat tabel baru, tapi memastikan semua kolom yang diperlukan ada
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('mahasiswa');
            });
        }
        
        if (!Schema::hasColumn('users', 'nim')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('nim')->nullable();
            });
        }
        
        if (!Schema::hasColumn('users', 'prodi_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('prodi_id')->nullable()->constrained('prodis');
            });
        }
        
        if (!Schema::hasColumn('users', 'angkatan')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('angkatan')->nullable();
            });
        }
        
        if (!Schema::hasColumn('users', 'profile_photo_path')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('profile_photo_path', 2048)->nullable();
            });
        }
        
        if (!Schema::hasColumn('users', 'tempat_lahir')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('tempat_lahir')->nullable();
            });
        }
        
        if (!Schema::hasColumn('users', 'tanggal_lahir')) {
            Schema::table('users', function (Blueprint $table) {
                $table->date('tanggal_lahir')->nullable();
            });
        }
        
        if (!Schema::hasColumn('users', 'nomor_ijazah')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('nomor_ijazah')->nullable();
            });
        }
        
        if (!Schema::hasColumn('users', 'jenis_kelamin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('jenis_kelamin')->nullable();
            });
        }
        
        if (!Schema::hasColumn('users', 'alamat')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('alamat')->nullable();
            });
        }
        
        if (!Schema::hasColumn('users', 'telepon')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('telepon')->nullable();
            });
        }
        
        if (!Schema::hasColumn('users', 'tahun_masuk')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('tahun_masuk')->nullable();
            });
        }
        
        if (!Schema::hasColumn('users', 'tahun_lulus')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('tahun_lulus')->nullable();
            });
        }
        
        if (!Schema::hasColumn('users', 'ipk')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('ipk')->nullable();
            });
        }
        
        if (!Schema::hasColumn('users', 'predikat')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('predikat')->nullable();
            });
        }
        
        if (!Schema::hasColumn('users', 'judul_skripsi')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('judul_skripsi')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu menghapus tabel, hanya kolom yang ditambahkan
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'nim',
                'prodi_id',
                'angkatan',
                'profile_photo_path',
                'tempat_lahir',
                'tanggal_lahir',
                'nomor_ijazah',
                'jenis_kelamin',
                'alamat',
                'telepon',
                'tahun_masuk',
                'tahun_lulus',
                'ipk',
                'predikat',
                'judul_skripsi'
            ]);
        });
    }
};