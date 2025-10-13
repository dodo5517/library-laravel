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
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0); // 0: pending, 1: approved, 2: rejected
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            //
        });
    }
};
