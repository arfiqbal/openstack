<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVMsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vm', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('ip_id')->unsigned();
                $table->integer('application_id')->unsigned();
                $table->string('dir');
                $table->string('name');
                $table->string('email');
                $table->boolean('active');
                $table->timestamps();
            
        });

        Schema::table('vm', function(Blueprint $table)
        {
            $table->foreign('ip_id')->references('id')->on('ips')->onDelete('cascade');
            $table->foreign('application_id')->references('id')->on('application')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vm');
    }
}
