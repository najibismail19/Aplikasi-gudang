<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        DB::table('customers')->insert([
            'id_customer' => "CS-001",
            'nama' => $faker->name,
            'kontak' => "081234431431",
            'alamat' => "Menteng Jakarta",
            'email' => $faker->email,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('customers')->insert([
            'id_customer' => "CS-002",
            'nama' => $faker->name,
            'kontak' => "081235134323",
            'alamat' => "Cipondoh",
            'email' => $faker->email,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('customers')->insert([
            'id_customer' => "CS-003",
            'nama' => $faker->name,
            'kontak' => "0812354234343",
            'alamat' => "Pamulang",
            'email' => $faker->email,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('customers')->insert([
            'id_customer' => "CS-004",
            'nama' => $faker->name,
            'kontak' => "081235412312213",
            'alamat' => "Bogor",
            'email' => $faker->email,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);

        DB::table('customers')->insert([
            'id_customer' => "CS-005",
            'nama' => $faker->name,
            'kontak' => "0812354123126",
            'alamat' => "Pandeglang",
            'email' => $faker->email,
            'deskripsi' => $faker->paragraphs(3, true),
        ]);
    }
}
