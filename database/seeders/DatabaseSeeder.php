<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // \App\Models\User::factory(2)->create();
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            UserRoleSeeder::class,
            CompanySeeder::class,
            CompanyInformationSeeder::class,
            UserCompanySeeder::class,
            MarkiStaliSeeder::class,
            StandardProductsSeeder::class,
            ContentRecordCategorySeeder::class,
            ThemeSeeder::class,
            ContentSheetMainPageSeeder::class
        ]);
    }
}
