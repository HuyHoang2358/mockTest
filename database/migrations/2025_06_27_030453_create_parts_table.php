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
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->foreign('exam_id')
                ->references('id')
                ->on('exams')
                ->onDelete('cascade');
            $table->unsignedBigInteger('exam_id')->index();
            $table->integer('number')->comment('Số thứ tự của phần thi, ví dụ: 1, 2, 3, etc.');
            $table->string('name',255)->comment('Tên phần thi, ví dụ: Part 1, Part 2, etc.');
            $table->string('description',500)->nullable()->comment('Mô tả ngắn về phần thi, ví dụ: Mô tả nội dung hoặc mục tiêu của phần thi.');
            $table->integer('time')->nullable()->default(0)->comment('Thời gian làm bài của phần, tính bằng phút');
            $table->longText('content')->nullable()->comment('Nội dung của phần thi, có thể là văn bản, câu hỏi, hoặc hướng dẫn.');
            $table->longText('attached_file')->nullable()->comment('json encode các file đính kèm liên quan đến phần thi, ví dụ: đề thi, audio, video, etc.');
            $table->string('part_type')->nullable()->comment('Loại phần: reading, listening, writing, speaking, etc.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
