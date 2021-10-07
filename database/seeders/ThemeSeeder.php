<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('theme_settings')
            ->insert([
                        [
                            'company_id' => '1',
                            'tpl_name' => 'tpl1',
                            'tpl_header_name' => 'header1',
                            'tpl_footer_name' => 'footer1'
                        ],
            ]);
    }
}
