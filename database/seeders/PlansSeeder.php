<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('plans')->delete();
        DB::table('plans')->insert([
            [
                'name' => 'Basic - One month',
                'price' => json_encode(['UAH' => 400 ,'EUR' => 10]),
                'type' => config('plans.types.basic'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Deluxe - One month',
                'price' => json_encode(['UAH' => 800 ,'EUR' => 20]),
                'type' => config('plans.types.deluxe'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
