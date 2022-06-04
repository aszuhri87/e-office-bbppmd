<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_letters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('letter_user_id')->nullable();
            $table->uuid('letter_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('letter_user_id')
            ->references('id')
            ->on('letter_users')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('letter_id')
            ->references('id')
            ->on('letters')
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
        Schema::dropIfExists('division_letters');
    }
}
