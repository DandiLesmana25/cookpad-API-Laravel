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
        Schema::create('alat', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->id('idalat');
            $table->string('nama_alat');
            $table->string('keterangan');
            $table->unsignedBigInteger('resep_idresep');
            $table->foreign('resep_idresep')
                  ->references('idresep')
                  ->on('resep')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};
