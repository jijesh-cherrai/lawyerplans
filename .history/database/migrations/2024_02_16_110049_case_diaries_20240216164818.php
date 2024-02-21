<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CaseDiaries extends Migration
{
    public function up()
    {
        Schema::create('case_diaries', function (Blueprint $table) {
            $table->id();
            $table->string('case_number');
            $table->foreignId('court_id')->references('id')->on('courts');
            $table->text('party_names');
            $table->date('case_date');
            $table->string('purpose');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('case_diaries', function (Blueprint $table) {
            $table->dropForeign(['court_id']); // Drop the foreign key constraint
        });
        Schema::dropIfExists('case_diaries');
    }
}
