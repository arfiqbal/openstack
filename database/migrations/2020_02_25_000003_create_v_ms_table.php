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
                $table->integer('application_id')->unsigned();
                $table->string('vm_uid');
                $table->string('dir');
                $table->string('name');
                $table->string('jira');
                $table->string('firstname');
                $table->string('lastname');
                $table->string('username');
                $table->string('hostname_code');
                $table->string('hostname');
                $table->string('pass');
                $table->boolean('user_exist')->default(0);
                $table->string('email');
                $table->string('project');
                $table->string('nic1');
                $table->string('nic2');
                $table->string('network');
                $table->string('flavor');
                $table->string('created_by');
                $table->string('deleted_by')->nullable();
                $table->boolean('active');
                $table->timestamps();
            
        });

        Schema::table('vm', function(Blueprint $table)
        {
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
