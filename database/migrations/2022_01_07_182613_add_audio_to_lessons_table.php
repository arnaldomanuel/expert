<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAudioToLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('audio_path')->after('pdf_link')->nullable();
            $table->text('audio_transcript')->after('pdf_link')->nullable();
            $table->boolean('has_video')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('audio_path');
            $table->dropColumn('audio_transcript');
           $table->dropColumn('has_video');

        });
    }
}
