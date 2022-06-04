<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('created_by')->nullable();
            $table->string('name')->nullable();
            $table->string('from')->nullable();
            $table->string('letter_number')->nullable();
            $table->timestamp('date')->nullable();
            $table->timestamp('received_date')->nullable();
            $table->string('agenda_number')->nullable();
            $table->string('trait')->nullable();
            $table->string('about')->nullable();
            $table->string('status')->nullable();
            $table->string('signature')->nullable();
            $table->string('letter_file')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')
            ->references('id')
            ->on('users')
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
        Schema::dropIfExists('letters');
    }
}
