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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->enum('role',['admin','user'])->default('user');
            $table->string('password');
            $table->string('email_validate')->nullable();
            $table->enum('status',['aktif','non-aktif'])->default('non-aktif');
            $table->dateTime('last_login');
            $table->timestamps();
            
            // $table->id();
            // $table->string('nama');
            // $table->string('email')->unique();
            // $table->enum('role',['admin','user'])->default('user');
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password');
            // // $table->string('email_validate')-nullable();
            // $table->enum('status',['aktif','non-atif'])->default('non-aktif');
            // $table->rememberToken();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
