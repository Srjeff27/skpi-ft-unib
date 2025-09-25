<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            // Rename existing columns to match new names
            $table->renameColumn('kategori', 'kategori_portfolio');
            $table->renameColumn('bukti_link', 'link_sertifikat');
            
            // Add new columns
            $table->string('nomor_dokumen')->nullable();
            $table->date('tanggal_dokumen')->nullable();
            $table->string('nama_dokumen_id')->nullable();
            $table->string('nama_dokumen_en')->nullable();
            
            // Drop unused columns
            $table->dropColumn(['tingkat', 'tanggal_mulai', 'tanggal_selesai']);
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            // Restore original column names
            $table->renameColumn('kategori_portfolio', 'kategori');
            $table->renameColumn('link_sertifikat', 'bukti_link');
            
            // Remove new columns
            $table->dropColumn([
                'nomor_dokumen',
                'tanggal_dokumen',
                'nama_dokumen_id',
                'nama_dokumen_en'
            ]);
            
            // Restore removed columns
            $table->string('tingkat')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
        });
    }
};