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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained()->on('folders')->onDelete('cascade');
            $table->string('name', 255);
            $table->string('code', 8)->unique();
            $table->biginteger('total_time')->default(0);
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->string('password',6)->nullable();
            $table->bigInteger('price')->default(0);
            $table->boolean('is_payment')->default(false);
            $table->integer('number_of_todo')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
