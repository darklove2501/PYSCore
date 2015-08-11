<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeTourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function(Blueprint $table){
            $table->increments('id');
            $table->integer('tourid')->unique();
            $table->string('tentour');
            $table->string('thoigian');
            $table->integer('gianguoilon', false, true);
            $table->integer('giatreem', false, true);
            $table->text('ghichu');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
}
