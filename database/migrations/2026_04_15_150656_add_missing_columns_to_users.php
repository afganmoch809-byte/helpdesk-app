<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom gender jika belum ada
            if (!Schema::hasColumn('users', 'gender')) {
                $table->enum('gender', ['male', 'female'])->nullable()->after('prodi');
            }
            
            // Tambah kolom birth_date jika belum ada
            if (!Schema::hasColumn('users', 'birth_date')) {
                $table->date('birth_date')->nullable()->after('gender');
            }
            
            // Tambah kolom phone jika belum ada
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('birth_date');
            }
            
            // Tambah kolom address jika belum ada
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['gender', 'birth_date', 'phone', 'address']);
        });
    }
};