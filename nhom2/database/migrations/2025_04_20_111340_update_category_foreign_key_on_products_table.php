<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCategoryForeignKeyOnProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Thay đổi category_id thành nullable
            $table->unsignedBigInteger('category_id')->nullable()->change();



            // Tạo lại khóa ngoại với hành động set null khi xóa
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Rollback về không cho phép category_id null
            $table->unsignedBigInteger('category_id')->nullable(false)->change();


            // Tạo lại khóa ngoại với hành động cascade khi xóa
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');
        });
    }
}
