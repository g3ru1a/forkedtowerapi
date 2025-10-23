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
        Schema::create('seats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('schedule_id')->constrained();
            $table->integer('number')->default(0);
            $table->foreignUuid('character_id')->nullable()->constrained();
            $table->foreignUuid('class_id')->nullable()->constrained('f_f_classes');
            $table->foreignUuid('registration_id')->nullable()->constrained();
            $table->boolean('is_raidlead')->default(false);
            $table->boolean('is_helper')->default(false);
            //Seat Variant Fields
            $table->foreignUuid('phantom_job_id')->nullable()->constrained('phantom_jobs');
            //.\ Seat Variant Fields
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
