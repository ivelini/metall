<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company')->insert([
            'name' => 'АО ЮУАЗ "СТАН-2000"',
            'full_name' => 'Акционерное общество Южно-Уральский Арматурный завод "СТАН-2000"',
            'address' => 'г.Челябинск, ул.Автоматики д.9',
            'email' => 'info@stan2000.ru',
            'phone' => '8-800-775-12-74'
        ]);
    }
}
