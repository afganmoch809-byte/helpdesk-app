<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ADMIN
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@helpdesk.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'nim' => null,
            'nip' => null,
            'nik' => null,
            'faculty' => 'Fakultas Teknik',
            'study_program' => null,
        ]);

        // 2. MAHASISWA
        User::create([
            'name' => 'Ahmad Rizki',
            'email' => 'mahasiswa@helpdesk.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
            'nim' => '20200101001',
            'nip' => null,
            'nik' => null,
            'faculty' => 'Fakultas Teknik',
            'study_program' => 'Teknik Informatika',
        ]);

        // 3. MAHASISWI
        User::create([
            'name' => 'Siti Aisyah',
            'email' => 'mahasiswi@helpdesk.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
            'nim' => '20200101002',
            'nip' => null,
            'nik' => null,
            'faculty' => 'Fakultas Ekonomi',
            'study_program' => 'Manajemen',
        ]);

        // 4. ASN (PNS/Dosen)
        User::create([
            'name' => 'Dr. Rina Wijaya',
            'email' => 'asn@helpdesk.com',
            'password' => Hash::make('password123'),
            'role' => 'asn',
            'nim' => null,
            'nip' => '198512012010012001',
            'nik' => null,
            'faculty' => 'Fakultas Teknik',
            'study_program' => 'Teknik Informatika',
        ]);

        // 5. NON ASN (Pegawai)
        User::create([
            'name' => 'Agus Setiawan',
            'email' => 'nonasn@helpdesk.com',
            'password' => Hash::make('password123'),
            'role' => 'non_asn',
            'nim' => null,
            'nip' => null,
            'nik' => '3175010101000001',
            'faculty' => 'Fakultas Teknik',
            'study_program' => null,
        ]);

        // 6. Mahasiswa Lain
        User::create([
            'name' => 'Rizky Pratama',
            'email' => 'rizky@example.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
            'nim' => '20200101003',
            'nip' => null,
            'nik' => null,
            'faculty' => 'Fakultas Ilmu Komputer',
            'study_program' => 'Sistem Informasi',
        ]);

        // 7. Mahasiswi Lain
        User::create([
            'name' => 'Nurul Hikmah',
            'email' => 'nurul@example.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
            'nim' => '20200101004',
            'nip' => null,
            'nik' => null,
            'faculty' => 'Fakultas Hukum',
            'study_program' => 'Ilmu Hukum',
        ]);

        // 8. Test User
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
            'nim' => '20209999001',
            'nip' => null,
            'nik' => null,
            'faculty' => 'Fakultas Teknik',
            'study_program' => 'Teknik Komputer',
        ]);
    }
}