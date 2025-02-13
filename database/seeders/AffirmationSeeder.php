<?php

namespace Database\Seeders;

use App\Models\Affirmation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AffirmationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {

            Affirmation::create([
                'intention_id' => rand(1, 20),
                'ar_text' => 'Arabic text ' . $i,
                'en_text' => 'English text ' . $i,
                "created_at" => Carbon::now(), # \Datetime()
                "updated_at" => Carbon::now()   # \Datetime()
            ]);
        }
    }
}
