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
        // \App\Models\User::factory(10)->create();
        $this->call([
            CountrySeeder::class,
            UserSeeder::class,
            AffirmationSeeder::class,
            BackgroundSeeder::class,
            EducationalLevelSeeder::class,
            HobbySeeder::class,
            IncomeLevelSeeder::class,
            IntentionSeeder::class,
            InterestSeeder::class,
            LetterSeeder::class,
            AdSeeder::class,

        ]);
    }
}
