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
        Schema::create('question_type_config_keys', function (Blueprint $table) {
            $table->id();
            $table->string('key', 255);
            $table->string('description', 500)->nullable();
            $table->longText('value')->nullable();
            $table->boolean('is_required')->default(true);
            $table->foreignId('question_type_id')->constrained('question_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_type_config_keys');
    }
};
