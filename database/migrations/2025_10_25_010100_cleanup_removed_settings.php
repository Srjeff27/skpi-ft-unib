<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('settings')) {
            DB::table('settings')->whereIn('key', [
                'permissions_map',
                'session_timeout_minutes',
                'pdf_header',
                'pdf_footer',
                'portfolio_open',
                'portfolio_close',
                'pdf_watermark_path',
            ])->delete();
        }
    }

    public function down(): void
    {
        // no-op
    }
};

