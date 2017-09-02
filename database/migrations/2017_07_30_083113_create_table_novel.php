<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNovel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug_novel');
            $table->string('judul_novel');
            $table->text('desc_novel');
            $table->unsignedInteger('id_tipe_novel');
            $table->string('author_novel');
            $table->string('raw_ft')->nullable();
            $table->text('url_raw_ft')->nullable();
            $table->string('raw_eng_ft')->nullable();
            $table->text('url_raw_eng_ft')->nullable();
            $table->unsignedInteger('id_user')->nullable();
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
        Schema::dropIfExists('novels');
    }
}
