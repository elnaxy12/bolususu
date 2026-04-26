<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('nip', 30)->unique();
            $table->string('email', 100)->unique();
            $table->string('telepon', 20)->nullable();
            $table->string('departemen', 100);
            $table->string('jabatan', 100);
            $table->date('tanggal_masuk');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
