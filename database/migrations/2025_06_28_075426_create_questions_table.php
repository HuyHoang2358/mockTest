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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Tên câu hỏi, có thể là tên của câu hỏi hoặc mô tả ngắn gọn');
            $table->integer('number')->default(0)->comment('Số thứ tự của câu hỏi trong nhóm');
            $table->foreignId('question_group_id')->constrained('question_groups')->onDelete('cascade');
            $table->double('score', 8, 2)->default(0)->comment('Điểm của câu hỏi');
            $table->longText('content')->nullable()->comment('Nội dung câu hỏi');
            $table->string('input_type')->nullable()->comment('Cách trả lời câu hỏi, có thể là text, textarea, radio, checkbox, select...');
            $table->foreignId('question_type_id')->constrained('question_types')->onDelete('cascade');
            $table->longText('attached_file')->nullable()->comment('File đính kèm câu hỏi, có thể là file docx, pdf, hình ảnh...');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
