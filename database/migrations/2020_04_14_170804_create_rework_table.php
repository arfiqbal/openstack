<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rework', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('vm_id');
            $table->string('flavor');
            $table->string('jira');
            $table->timestamps();
        });
        // Schema::table('rework', function(Blueprint $table)
        // {
        //     $table->foreign('application_id')->references('id')->on('application');
        //     $table->foreign('vm')->references('id')->on('vm');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rework');
    }
}
