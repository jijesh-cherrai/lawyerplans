<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOppositLawyerToCaseDiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_diaries', function (Blueprint $table) {
            Schema::table('case_diaries', function (Blueprint $table) {
                $table->string('opposit_lawyer')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_diaries', function (Blueprint $table) {
                $table->dropColumn('opposit_lawyer');
        });
    }
}
