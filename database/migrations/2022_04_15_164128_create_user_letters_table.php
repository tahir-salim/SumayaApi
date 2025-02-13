<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('letter_id')->nullable();
            $table->timestamp('date_time');
            $table->foreignId('notification_id')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('shared_at')->nullable();
            $table->integer('shared_with_background_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_letters');
    }
}
