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
        Schema::create('borrow_requests', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete(); // clients 테이블 참조
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete(); // books 테이블 참조
            $table->timestamp('request_date')->useCurrent(); // 요청 날짜
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrow_requests');
    }
};
