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
            $table->foreignUuid('preferred_class_id')->constrained('f_f_classes')->cascadeOnDelete();
            $table->foreignUuid('preferred_job_id')->constrained('phantom_jobs')->cascadeOnDelete();
            $table->boolean('can_solo_heal')->default(false);
            $table->boolean('can_english')->default(false);
            $table->boolean('can_markers')->default(false);
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('registration_flex_classes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->foreignUuid('class_id')->constrained('f_f_classes')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('registration_flex_jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->foreignUuid('job_id')->constrained('phantom_jobs')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('registration_flex_classes');
        Schema::dropIfExists('registration_flex_jobs');
    }
};
