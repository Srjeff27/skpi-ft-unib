<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finalizations', function (Blueprint $table) {
            $table->id();
            $table->string('period_ym')->unique(); // format YYYY-MM
            $table->foreignId('official_id')->nullable()->constrained('officials')->nullOnDelete();
            $table->boolean('is_locked')->default(false);
            $table->timestamp('locked_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finalizations');
    }
};

