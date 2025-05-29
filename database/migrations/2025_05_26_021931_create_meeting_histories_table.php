<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meeting_histories', function (Blueprint $table) {
            $table->id();

            // Liên kết phòng họp
            $table->foreignId('meeting_room_id')->constrained('meeting_rooms')->onDelete('cascade');

            $table->string('devices')->nullable(); 

            // Nội dung cuộc họp
            $table->string('title');

            // Thời gian bắt đầu & kết thúc (ngày phải giống nhau — xử lý validation phía controller)
            $table->time('start_time');
            $table->time('end_time');
            $table->date('date'); // dùng chung cho start/end

            // Người liên quan (bắt buộc, lưu array JSON)
            $table->json('related_users');

            // Người quyết định (foreign key tới bảng users)
            $table->foreignId('decision_maker_id')->constrained('users')->onDelete('restrict');

            // Thành phần chuyên môn (array, không bắt buộc)
            $table->json('specialist_users')->nullable();

            $table->json('advisor_users')->nullable(); // ← thêm dòng này

            // Ghi chú
            $table->text('note')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            // Chủ trì
            $table->string('moderator')->nullable();

            // Thư ký (array, không bắt buộc)
            $table->json('secretary_users')->nullable();

            // File đính kèm (lưu tên file hoặc đường dẫn)
            $table->string('attachment_path')->nullable();

            // Nơi ghi nhận kết quả
            $table->string('result_record_location')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_histories');
    }
};
