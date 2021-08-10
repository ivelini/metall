<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StandardProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('catalog_standards_product')->insert([
            ['name' => 'ГОСТ 17375-2001', 'code' => 'GOST_17375-2001'],
        ]);
    }
}
