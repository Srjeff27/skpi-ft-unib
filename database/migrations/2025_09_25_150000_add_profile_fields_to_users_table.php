<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nomor_hp')->nullable();
            // Data Kelulusan
            $table->date('tanggal_lulus')->nullable();
            $table->string('nomor_ijazah')->nullable();
            $table->string('nomor_skpi')->nullable();
            $table->string('gelar_id')->nullable();
            $table->string('gelar_en')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir',
                'tanggal_lahir',
                'nomor_hp',
                'tanggal_lulus',
                'nomor_ijazah',
                'nomor_skpi',
                'gelar_id',
                'gelar_en',
            ]);
        });
    }
};