<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fantranslations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_ft');
            $table->text('slug');
            $table->text('url');
            $table->unsignedInteger('id_user')->nullable();
            $table->integer('approve')->default(0);
            $table->integer('deleted')->default(0);
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
        Schema::dropIfExists('fantranslations');
    }
}
