<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Nếu DB đang dùng MySQL, bạn cần cast kiểu bằng raw SQL
            $table->unsignedTinyInteger('status')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }
};
