<?php

namespace Database\Seeders;

use App\Models\Hobby;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {

            Hobby::create([
                'name_en' => 'name_en ' . $i,
                'name_ar' => 'name_ar ' . $i,
                'user_id' => rand(1, 20),
                "created_at" => Carbon::now(), # \Datetime()
                "updated_at" => Carbon::now()   # \Datetime()
            ]);
        }
    }
}
