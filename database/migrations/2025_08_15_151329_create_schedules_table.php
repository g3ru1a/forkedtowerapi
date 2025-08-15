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
            $table->text('description');
            $table->boolean('registration_open')->default(false);
            $table->timestamp('registration_deadline')->nullable();
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
