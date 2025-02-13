<?php

namespace Database\Seeders;

use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {

            Ad::create([
                'client_name' => 'client_name ' . $i,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now(),
                'url' => 'url/' . rand(0, 10) . '/' . $i . '/vimeo.com',
                'status' =>  Arr::random(['DRAFT', 'ACTIVE', 'ENDED']),
                'image' => 'images/ ' . $i,
                'title' => 'Title ' . $i,
                'body' => 'Body ' . $i,
                'is_sumaya_publication' => rand(0, 1),
                "created_at" => Carbon::now(), # \Datetime()
                "updated_at" => Carbon::now()   # \Datetime()
            ]);
        }
    }
}
