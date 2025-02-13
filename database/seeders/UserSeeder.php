<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@klabs.co',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('admin@123'),
                'role' => UserRole::ADMIN,
                'is_blocked' => false,
                "created_at" => Carbon::now(), # \Datetime()
                "updated_at" => Carbon::now()   # \Datetime()
            ],
            [
                'name' => 'Dr Sumaya',
                'email' => 'sumaya@klabs.co',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('user@123'),
                'role' => UserRole::USER,
                'is_blocked' => false,
                "created_at" =>  Carbon::now(), # \Datetime()
                "updated_at" => Carbon::now()   # \Datetime()
            ],
            [
                'name' => 'Tahir',
                'email' => 'tahir@klabs.co',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('user@123'),
                'role' => UserRole::USER,
                'is_blocked' => false,
                "created_at" =>  Carbon::now(), # \Datetime()
                "updated_at" => Carbon::now()   # \Datetime()
            ],
            [
                'name' => 'Ashar',
                'email' => 'ashar@klabs.co',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('user@123'),
                'role' => UserRole::USER,
                'is_blocked' => false,
                "created_at" =>  Carbon::now(), # \Datetime()
                "updated_at" => Carbon::now()   # \Datetime()
            ],
            [
                'name' => 'Arham',
                'email' => 'arham@klabs.co',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('user@123'),
                'role' => UserRole::USER,
                'is_blocked' => false,
                "created_at" =>  Carbon::now(), # \Datetime()
                "updated_at" => Carbon::now()   # \Datetime()
            ],
            [
                'name' => 'Osama',
                'email' => 'osama@klabs.co',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('user@123'),
                'role' => UserRole::USER,
                'is_blocked' => false,
                "created_at" =>  Carbon::now(), # \Datetime()
                "updated_at" => Carbon::now()   # \Datetime()
            ],

        ];
        DB::table('users')->insert($user);
    }
}
