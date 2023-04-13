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


        Schema::create('rating', function (Blueprint $table) {
            $table->id('idrating');
            $table->integer('rating');
            $table->string('review')->nullable();
            $table->unsignedBigInteger('resep_idresep');
            $table->foreign('resep_idresep')->references('idresep')->on('resep')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('email_user');
            $table->foreign('email_user')->references('email')->on('user')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        // Schema::create('rating', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating');
    }
};
