<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('portfolio_categories', 'max_upload_kb')) {
            Schema::table('portfolio_categories', function (Blueprint $table) {
                $table->dropColumn('max_upload_kb');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('portfolio_categories', 'max_upload_kb')) {
            Schema::table('portfolio_categories', function (Blueprint $table) {
                $table->unsignedInteger('max_upload_kb')->default(2048);
            });
        }
    }
};

