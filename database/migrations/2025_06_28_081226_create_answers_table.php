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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->string('label')->nullable()->comment('Nhãn của câu trả lời, ví dụ: A, B, C, D');
            $table->longText('value')->nullable()->comment('Nội dung câu trả lời');
            $table->boolean('is_correct')->default(false)->comment('Trạng thái đúng/sai của câu trả lời');
            $table->longText('note')->nullable()->comment('Ghi chú cho câu trả lời, có thể là giải thích hoặc hướng dẫn');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
