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
        Schema::table('karirs', function (Blueprint $table) {
            $table->string('kontak')->nullable()->after('gambar');
            $table->json('benefit')->nullable()->after('kontak');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('karirs', function (Blueprint $table) {
            $table->dropColumn(['kontak', 'benefit']);
        });
    }
};
