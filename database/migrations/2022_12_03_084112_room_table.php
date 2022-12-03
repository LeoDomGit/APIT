<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roomTable', function (Blueprint $table) {
            $table->integer('id',true,false);
            $table->string('roomname');
            $table->string('address');
            $table->string('price');
            $table->string('phone');
            $table->string('image');
            $table->string('dientich');
            $table->text('mota');
            $table->integer('idQuan',false,false);
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->foreign('idQuan')->references('id')->on('quanTable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roomTable');
    }
};
