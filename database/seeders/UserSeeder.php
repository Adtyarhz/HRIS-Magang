<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Employee;
use App\Models\Division;
use App\Models\Position;

class UserSeeder extends Seeder
{
    // private $maleFirstNames = ['Budi', 'Joko', 'Agus', 'Eko', 'Asep', 'Doni', 'Rian', 'Fajar', 'Aditya', 'Rizky'];
    // private $femaleFirstNames = ['Siti', 'Dewi', 'Sri', 'Ani', 'Putri', 'Rina', 'Wulan', 'Dian', 'Fitri', 'Nina'];
    // private $lastNames = ['Santoso', 'Wijaya', 'Kusuma', 'Gunawan', 'Pratama', 'Wibowo', 'Nugroho', 'Setiawan', 'Susanto', 'Halim'];
    // private $cities = ['Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang', 'Makassar', 'Palembang', 'Depok', 'Tangerang', 'Yogyakarta'];

    public function run(): void
    {
        // $faker = Faker::create('id_ID');
        // $positions = Position::pluck('id', 'title')->all();
        // $divisions = Division::all();

        $this->createSuperAdmin();
        // $this->createPresidentDirector($faker, $positions);

        // foreach ($divisions as $division) {
        //     $this->createDivisionTeam($faker, $division, $positions);
        // }

        // $this->command->info('✅ UserSeeder selesai. Semua role dan divisi berhasil dibuat dengan data acak.');
    }

    /**
     * Membuat pengguna Superadmin.
     */
    private function createSuperAdmin()
    {
        User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
        ]);
    }
}

