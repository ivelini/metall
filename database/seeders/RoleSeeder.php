<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'Администратор портала', 'code' => 'global_admin'],
            ['name' => 'Администратор предприятия', 'code' => 'local_admin'],
            ['name' => 'Пользователь', 'code' => 'local_user']
        ]);
    }
}
