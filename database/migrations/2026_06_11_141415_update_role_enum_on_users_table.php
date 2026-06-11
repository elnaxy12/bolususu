<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('owner', 'karyawan', 'customer')
            NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('owner', 'karyawan')
            NOT NULL
        ");
    }
};
