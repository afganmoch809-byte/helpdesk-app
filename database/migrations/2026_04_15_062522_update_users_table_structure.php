<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom yang tidak dipakai
            if (Schema::hasColumn('users', 'nim')) {
                $table->dropColumn('nim');
            }
            if (Schema::hasColumn('users', 'nip')) {
                $table->dropColumn('nip');
            }
            if (Schema::hasColumn('users', 'nik')) {
                $table->dropColumn('nik');
            }
            
            // Hapus kolom role (akan diganti dengan user_type)
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            
            // Hapus kolom faculty (akan diganti dengan fakultas)
            if (Schema::hasColumn('users', 'faculty')) {
                $table->dropColumn('faculty');
            }
            
            // Hapus kolom study_program (akan diganti dengan prodi)
            if (Schema::hasColumn('users', 'study_program')) {
                $table->dropColumn('study_program');
            }
            
            // Tambah kolom baru
            if (!Schema::hasColumn('users', 'user_type')) {
                $table->enum('user_type', ['admin', 'mahasiswa', 'pegawai_asn', 'pegawai_non_asn'])->default('mahasiswa')->after('email');
            }
            
            if (!Schema::hasColumn('users', 'fakultas')) {
                $table->string('fakultas')->nullable()->after('user_type');
            }
            
            if (!Schema::hasColumn('users', 'prodi')) {
                $table->string('prodi')->nullable()->after('fakultas');
            }
            
            if (!Schema::hasColumn('users', 'profile_completed')) {
                $table->boolean('profile_completed')->default(0)->after('prodi');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan kolom yang dihapus
            $table->string('nim')->unique()->nullable();
            $table->string('nip')->unique()->nullable();
            $table->string('nik')->unique()->nullable();
            $table->enum('role', ['admin', 'mahasiswa', 'asn', 'non_asn'])->default('mahasiswa');
            $table->string('faculty')->nullable();
            $table->string('study_program')->nullable();
            
            // Hapus kolom baru
            $table->dropColumn(['user_type', 'fakultas', 'prodi', 'profile_completed']);
        });
    }
};