<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcductFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procduct_form', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->tinyinteger('type')->comment('1=mini category,2=lead form');
			$table->boolean('status')->default(0);
            $table->bigInteger('added_by');
            $table->bigInteger('approved_by');
            $table->timestamps();
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
        Schema::dropIfExists('procduct_form');
    }
}
