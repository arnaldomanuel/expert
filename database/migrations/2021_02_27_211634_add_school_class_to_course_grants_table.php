<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function PHPUnit\Framework\once;

class AddSchoolClassToCourseGrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_grants', function (Blueprint $table) {
            $table->unsignedBigInteger('school_classs_id')->nullable();
            $table->foreign('school_classs_id')->references('id')->on('school_classes');
              });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_grants', function (Blueprint $table) {
            //
        });
    }
}
