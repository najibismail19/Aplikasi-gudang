<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        DB::table('supplier')->insert([
            'id_supplier' => "SU-001",
            'nama' => "Toko Honda",
            'kontak' => "0857802341",
            'alamat' => "Kota Jakarta",
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('supplier')->insert([
            'id_supplier' => "SU-002",
            'nama' => "Toko Yamaha",
            'kontak' => "081392327815",
            'alamat' => "Kota Tangerang",
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('supplier')->insert([
            'id_supplier' => "SU-003",
            'nama' => "Toko Suzuki",
            'kontak' => "0812375322",
            'alamat' => "Kota Bekasi",
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('supplier')->insert([
            'id_supplier' => "SU-004",
            'nama' => "Toko Dugati",
            'kontak' => "081234375322",
            'alamat' => "Kota Bandung",
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('supplier')->insert([
            'id_supplier' => "SU-005",
            'nama' => "Toko Astra",
            'kontak' => "0812343753435",
            'alamat' => "Kota Jawa Timur",
            'deskripsi' => $faker->paragraphs(3, true),
        ]);
    }
}
