<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portofolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->text('deskripsi_panjang')->nullable();
            $table->text('tools_pengembangan')->nullable(); // Bisa disimpan sebagai string atau json
            $table->string('deskripsi_keunggulan_singkat')->nullable();
            $table->json('advantages')->nullable(); // Menyimpan array icon, judul, teks
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portofolios');
    }
};
