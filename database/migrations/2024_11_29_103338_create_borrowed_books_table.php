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
        Schema::create('borrowed_books', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete(); // clents 테이블 참조
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete(); // books 테이블 참조
            $table->timestamp('borrow_date')->useCurrent(); // 대출 날짜, 기본값 현재 시간
            $table->date('due_date'); // 반납 예정일
            $table->date('returned_date')->nullable(); // 반납 날짜 (nullable)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrowed_books');
    }
};
