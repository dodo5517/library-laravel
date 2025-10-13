<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete(); // users 테이블 참조
            $table->string('action', 255); // 작업 기록
            $table->foreignId('book_id')->nullable()->constrained('books')->nullOnDelete(); // books 테이블 참조
            $table->timestamp('timestamp')->useCurrent(); // 로그 생성 시간
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
};
