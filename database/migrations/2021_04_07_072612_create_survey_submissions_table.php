<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveySubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_submissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('survey_attribute_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->text('value');
            $table->foreign('survey_attribute_id')
            ->references('id')
            ->on('survey_attributes');
            $table->foreign('user_id')
            ->references('id')
            ->on('users');            
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
        Schema::dropIfExists('survey_submissions');
    }
}
