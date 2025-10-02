<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            if (!Schema::hasColumn('portfolios','is_locked')) {
                $table->boolean('is_locked')->default(false)->after('status');
            }
            if (!Schema::hasColumn('portfolios','finalized_at')) {
                $table->timestamp('finalized_at')->nullable()->after('is_locked');
            }
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            if (Schema::hasColumn('portfolios','finalized_at')) $table->dropColumn('finalized_at');
            if (Schema::hasColumn('portfolios','is_locked')) $table->dropColumn('is_locked');
        });
    }
};

