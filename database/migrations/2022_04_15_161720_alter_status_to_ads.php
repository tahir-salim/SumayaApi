<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterStatusToAds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `ads` CHANGE `status` `status` ENUM('DRAFT', 'ACTIVE', 'ENDED') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('ads', function (Blueprint $table) {
        //     $table->enum('status', ['ACTIVE', 'NOT_ACTIVE', 'ENDED', 'DELETED']);
        // });
    }
}
