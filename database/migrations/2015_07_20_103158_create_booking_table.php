<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hoten');
            $table->string('email');
            $table->string('sdt');
            $table->string('diachi');
            $table->date('ngaydi');
            $table->text('yeucau');
            $table->tinyInteger('thanhtoan'); //Hình thức thanh toán, 0 = Chuyển khoản ngân hàng, 1 = Đến văn phòng
            $table->text('ghichu');
            $table->integer('tour_id', false, true);
            $table->smallInteger('songuoilon', false, true);
            $table->smallInteger('sotreem', false, true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
