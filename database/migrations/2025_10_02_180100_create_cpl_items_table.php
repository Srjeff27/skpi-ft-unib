<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cpl_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id')->constrained('curricula')->cascadeOnDelete();
            $table->string('category'); // sikap, pengetahuan, umum, khusus
            $table->string('code')->nullable();
            $table->text('desc_id');
            $table->text('desc_en')->nullable();
            $table->unsignedSmallInteger('order')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cpl_items');
    }
};

