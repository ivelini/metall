<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ContentSheetMainPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('content_sheet_main_page')->insert([
            'company_id' => '1'
        ]);
    }
}
