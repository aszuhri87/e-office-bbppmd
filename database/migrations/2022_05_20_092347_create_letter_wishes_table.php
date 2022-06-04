<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterWishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_wishes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('unit_letter_id')->nullable();
            $table->uuid('wish_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('unit_letter_id')
            ->references('id')
            ->on('unit_letters')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('wish_id')
            ->references('id')
            ->on('wishes')
            ->onUpdate('cascade')
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
        Schema::dropIfExists('letter_wishes');
    }
}
