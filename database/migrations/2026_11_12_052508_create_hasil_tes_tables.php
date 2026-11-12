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
        Schema::create('hasil_tes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->enum('tipe', ['pretest', 'posttest']);
        $table->unsignedTinyInteger('usia');
        $table->unsignedBigInteger('status_penggunaan_id');
        $table->unsignedTinyInteger('jumlah_benar');
        $table->unsignedTinyInteger('total_soal');
        $table->unsignedTinyInteger('skor');          // 0-100
        $table->timestamps();

        $table->unique(['user_id', 'tipe']);          // satu kali per tipe
    });

        Schema::create('hasil_tes_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hasil_tes_id')->constrained('hasil_tes')->cascadeOnDelete();
            $table->unsignedBigInteger('pertanyaan_id');
            $table->unsignedBigInteger('jawaban_id');
            $table->boolean('benar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_tes_jawaban');
        Schema::dropIfExists('hasil_tes');
    }
};
