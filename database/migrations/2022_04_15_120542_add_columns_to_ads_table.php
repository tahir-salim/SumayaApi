<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->string('image')->nullable()->after('status');
            $table->string('title')->nullable()->after('image');
            $table->string('body')->nullable()->after('title');
            $table->boolean('is_sumaya_publication')->nullable()->after('body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('title');
            $table->dropColumn('body');
            $table->dropColumn('is_sumaya_publication');
        });
    }
}
