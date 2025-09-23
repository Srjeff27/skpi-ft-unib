<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('mahasiswa')->after('password');
            }
            if (! Schema::hasColumn('users', 'nim')) {
                $table->string('nim')->unique()->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'prodi_id')) {
                $table->foreignId('prodi_id')->nullable()->constrained('prodis')->nullOnDelete()->after('role');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'prodi_id')) {
                $table->dropConstrainedForeignId('prodi_id');
            }
            if (Schema::hasColumn('users', 'nim')) {
                $table->dropColumn('nim');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};

