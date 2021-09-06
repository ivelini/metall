<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentRecordCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('content_record_category')->insert([
            [
                'h1' => 'Без категоррии',
                'slug' => 'bez_categorii',
                'company_id' => '1'
            ],
        ]);
    }
}
