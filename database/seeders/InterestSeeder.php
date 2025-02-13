<?php

namespace Database\Seeders;

use App\Models\Interest;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {

            Interest::create([
                'name_en' => 'name_en ' . $i,
                'name_ar' => 'name_ar ' . $i,
                "created_at" => Carbon::now(), # \Datetime()
                "updated_at" => Carbon::now()   # \Datetime()
            ]);
        }
    }
}
