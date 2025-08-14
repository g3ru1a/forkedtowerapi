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
        Schema::create('phantom_jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('icon_url');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('character_phantom_job', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('character_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('phantom_job_id')->constrained()->cascadeOnDelete();
            $table->integer('level')->default(0);
            $table->integer('current_xp')->default(0);
            $table->integer('max_xp')->default(0);
            $table->boolean('mastered')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['character_id', 'phantom_job_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phantom_jobs');
        Schema::dropIfExists('character_phantom_job');
    }
};
