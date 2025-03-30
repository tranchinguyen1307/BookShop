<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('image')->nullable()->after('password');
            $table->text('address')->nullable()->after('image');
            $table->string('auth_provider')->nullable()->after('address');
            $table->string('auth_provider_id')->nullable()->after('auth_provider');
            // $table->foreignId('role_id')->nullable()->after('auth_provider_id')->constrained('roles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'image', 'address', 'auth_provider', 'auth_provider_id', 'role_id']);
        });
    }
};
