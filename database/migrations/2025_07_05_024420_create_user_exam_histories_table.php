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
        Schema::create('user_exam_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('guest_id')->nullable();
            $table->string('user_name')->nullable();
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('status')->default('OPEN'); // OPEN, DOING, DONE, ERROR, CHECKED, CHECKING
            $table->double('score')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_exam_histories');
    }
};
