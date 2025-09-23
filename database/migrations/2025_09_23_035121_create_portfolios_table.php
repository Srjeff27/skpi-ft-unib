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
        if (! Schema::hasTable('portfolios')) {
            Schema::create('portfolios', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('kategori');
                $table->string('judul_kegiatan');
                $table->string('penyelenggara');
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai')->nullable();
                $table->text('deskripsi_kegiatan')->nullable();
                $table->string('bukti_link');
                // Status: 'pending', 'verified', 'rejected'
                $table->string('status')->default('pending');
                $table->text('catatan_verifikator')->nullable();
                $table->foreignId('verified_by')->nullable()->constrained('users');
                $table->timestamp('verified_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
