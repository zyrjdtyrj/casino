<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prizes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gambler_id');
            $table->enum('type', ['Gift','Bonus','Money']);
            $table->enum('state', ['wait', 'canceled', 'received', 'converted']);
            $table->longText('prize');
            $table->timestamps();
            $table->foreign('gambler_id')
                ->references('id')
                ->on('gamblers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prizes');
    }
}
