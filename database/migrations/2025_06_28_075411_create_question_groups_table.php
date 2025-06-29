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
        Schema::create('question_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_id')->constrained('parts')->onDelete('cascade');
            $table->string('name',255)->nullable()->comment('Tên nhóm câu hỏi');
            $table->longText('content')->nullable()->comment('Nội dung mô tả nhóm câu hỏi');
            $table->longText('attached_file')->nullable()->comment('File đính kèm nhóm câu hỏi, có thể là file docx, pdf, hình ảnh...');
            $table->boolean('answer_inside_content')->default(false)->comment('Trạng thái hiển thị đáp án trong nội dung nhóm câu hỏi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_groups');
    }
};
