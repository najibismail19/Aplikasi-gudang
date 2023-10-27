<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0001",
            'nama' => "Motor Vario New 2024",
            'satuan' => "Unit",
            'harga' => 25000000,
            'jenis' => 1,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0002",
            'nama' => "Motor Mio New 2024",
            'satuan' => "Unit",
            'harga' => 21000000,
            'jenis' => 1,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0003",
            'nama' => "Motor CBR New 2024",
            'satuan' => "Unit",
            'harga' => 35000000,
            'jenis' => 1,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0004",
            'nama' => "Ban Motor Battlax",
            'satuan' => "Pcs",
            'harga' => 625000,
            'jenis' => 0,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0005",
            'nama' => "Ban Motor Michelin",
            'satuan' => "Pcs",
            'harga' => 245000,
            'jenis' => 0,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);


        DB::table('produk')->insert([
            'kode_produk' => "PDK-0006",
            'nama' => "Pelek Motor",
            'satuan' => "Pcs",
            'harga' => 500000,
            'jenis' => 0,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0006",
            'nama' => "Jok Motor",
            'satuan' => "Pcs",
            'harga' => 100000,
            'jenis' => 0,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0007",
            'nama' => "Stang Motor",
            'satuan' => "Pcs",
            'harga' => 750000,
            'jenis' => 0,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0008",
            'nama' => "Lampu Motor",
            'satuan' => "Pcs",
            'harga' => 550000,
            'jenis' => 0,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0009",
            'nama' => "Kaca Spion",
            'satuan' => "Pcs",
            'harga' => 50000,
            'jenis' => 0,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0010",
            'nama' => "Piringan Rem",
            'satuan' => "Pcs",
            'harga' => 450000,
            'jenis' => 0,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0011",
            'nama' => "Kampas Rem",
            'satuan' => "Pcs",
            'harga' => 50000,
            'jenis' => 0,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0012",
            'nama' => "Oli Shell",
            'satuan' => "Pcs",
            'harga' => 75000,
            'jenis' => 0,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0013",
            'nama' => "Body Motor 1 Set",
            'satuan' => "Pcs",
            'harga' => 1500000,
            'jenis' => 0,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0014",
            'nama' => "Standar Motor",
            'satuan' => "Pcs",
            'harga' => 145000,
            'jenis' => 0,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('produk')->insert([
            'kode_produk' => "PDK-0015",
            'nama' => "Rem Tangan 1 Set",
            'satuan' => "Pcs",
            'harga' => 230000,
            'jenis' => 0,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);
    }
}
