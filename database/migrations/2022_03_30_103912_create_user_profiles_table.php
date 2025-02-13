<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique();
            $table->date('date_of_birth');
            $table->foreignId('country_id')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE'])->nullable();
            $table->enum('marital_status', ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']);
            $table->integer('max_reminders_per_day');
            $table->integer('min_reminders_per_day');
            $table->string('phone');
            $table->time('start_time');
            $table->time('end_time');
            $table->foreignId('income_level_id')->nullable();
            $table->foreignId('education_level_id')->nullable();
            $table->foreignId('intention_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
