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
        Schema::create('schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('group_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('host_id')->constrained('characters', 'id')->cascadeOnDelete();
            $table->foreignUuid('type_id')->constrained('run_types', 'id');
            $table->boolean('public')->default(false);
            $table->date('date');
            $table->time('time');
            $table->text('description')->nullable();
            $table->boolean('require_registration')->default(false);
            $table->integer('duration_hours')->default(3);
            $table->enum('status', ['planned', 'scheduled', 'recruiting', 'ongoing', 'finished', 'cancelled'])->default('planned');
            // Currently only 48 for forked tower, this can be adjusted to support different content.
            $table->foreignUuid('fight_id')->constrained();
            $table->integer('seat_count')->default(48);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
