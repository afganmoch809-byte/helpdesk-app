<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'mahasiswa', 'asn', 'non_asn'])->default('mahasiswa');
            }
            if (!Schema::hasColumn('users', 'nim')) {
                $table->string('nim')->unique()->nullable();
            }
            if (!Schema::hasColumn('users', 'nip')) {
                $table->string('nip')->unique()->nullable();
            }
            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik')->unique()->nullable();
            }
            if (!Schema::hasColumn('users', 'faculty')) {
                $table->string('faculty')->nullable();
            }
            if (!Schema::hasColumn('users', 'study_program')) {
                $table->string('study_program')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nim', 'nip', 'nik', 'faculty', 'study_program']);
        });
    }
};