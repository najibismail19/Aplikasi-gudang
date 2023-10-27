<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 7 ; $i++) {
            $phoneNumber = $faker->unique()->phoneNumber;
            $indonesianPhoneNumber = '+62' . substr($phoneNumber, 1);

            $genders = ['Laki-laki', 'Perempuan'];
            DB::table('karyawan')->insert([
                'nik' => "00" . $i,
                'nama' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('rahasia'),
                'id_jabatan' => 'J00' . $i,
                'id_gudang' => "G00" . rand(1, 5),
                'kontak' => $indonesianPhoneNumber,
                'gambar_profile' => 'default.png',
                'gender' => $genders[array_rand($genders)],
                'tanggal_lahir' => $faker->date($format = 'Y-m-d', $max = '2000-01-01')
            ]);
        }

    }
}
