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
        Schema::create('registrations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('character_id')->constrained('characters')->cascadeOnDelete();
            $table->string('preferred_class');
            $table->string('preferred_job');
            $table->string('flex_classes')->nullable();
            $table->string('flex_jobs')->nullable();
            $table->boolean('can_solo_heal')->default(false);
            $table->boolean('can_english')->default(false);
            $table->boolean('can_markers')->default(false);
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
