<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('finalizations')) {
            Schema::drop('finalizations');
        }

        if (Schema::hasColumn('portfolios', 'is_locked') || Schema::hasColumn('portfolios', 'finalized_at')) {
            Schema::table('portfolios', function (Blueprint $table) {
                if (Schema::hasColumn('portfolios', 'is_locked')) {
                    $table->dropColumn('is_locked');
                }
                if (Schema::hasColumn('portfolios', 'finalized_at')) {
                    $table->dropColumn('finalized_at');
                }
            });
        }
    }

    public function down(): void
    {
        // Recreate structure minimally if rollback is needed
        if (!Schema::hasTable('finalizations')) {
            Schema::create('finalizations', function (Blueprint $table) {
                $table->id();
                $table->string('period_ym');
                $table->foreignId('official_id')->nullable()->constrained('officials')->nullOnDelete();
                $table->boolean('is_locked')->default(false);
                $table->timestamp('locked_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasColumn('portfolios', 'is_locked') || !Schema::hasColumn('portfolios', 'finalized_at')) {
            Schema::table('portfolios', function (Blueprint $table) {
                if (!Schema::hasColumn('portfolios', 'is_locked')) {
                    $table->boolean('is_locked')->default(false)->after('status');
                }
                if (!Schema::hasColumn('portfolios', 'finalized_at')) {
                    $table->timestamp('finalized_at')->nullable()->after('is_locked');
                }
            });
        }
    }
};

