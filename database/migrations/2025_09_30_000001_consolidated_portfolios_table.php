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
        
        // Dari migrasi 2025_09_23_174907_add_catatan_verifikator_to_portfolios_table
        if (!Schema::hasColumn('portfolios', 'catatan_verifikator')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->text('catatan_verifikator')->nullable();
            });
        }
        
        if (!Schema::hasColumn('portfolios', 'verified_by')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->foreignId('verified_by')->nullable()->constrained('users');
            });
        }
        
        if (!Schema::hasColumn('portfolios', 'verified_at')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->timestamp('verified_at')->nullable();
            });
        }
        
        // Dari migrasi 2025_09_23_181311_add_tingkat_to_portfolios_table dan 2025_09_29_100000_add_tingkat_to_portfolios_table
        if (!Schema::hasColumn('portfolios', 'tingkat')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->string('tingkat')->nullable();
            });
        }
        
        // Dari migrasi 2025_10_02_200100_add_lock_columns_to_portfolios_table
        if (!Schema::hasColumn('portfolios', 'is_locked')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->boolean('is_locked')->default(false);
            });
        }
        
        if (!Schema::hasColumn('portfolios', 'locked_at')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->timestamp('locked_at')->nullable();
            });
        }
        
        if (!Schema::hasColumn('portfolios', 'locked_by')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->foreignId('locked_by')->nullable()->constrained('users');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu menghapus tabel, hanya kolom yang ditambahkan
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn([
                'catatan_verifikator',
                'verified_by',
                'verified_at',
                'tingkat',
                'is_locked',
                'locked_at',
                'locked_by'
            ]);
        });
    }
};