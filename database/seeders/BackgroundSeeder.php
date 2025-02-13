<?php

namespace Database\Seeders;

use App\Models\Background;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BackgroundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {

            Background::create([
                'name' => 'client_name ' . $i,
                'image_url' => 'image_url/' . rand(0, 10) . '/' . $i . '/vimeo.com',
                'user_id' => rand(1, 20),
                "created_at" => Carbon::now(), # \Datetime()
                "updated_at" => Carbon::now()   # \Datetime()
            ]);
        }
    }
}
