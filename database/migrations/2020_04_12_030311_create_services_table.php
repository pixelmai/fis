<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit');
            $table->tinyInteger('servcats_id');
            $table->tinyInteger('servicesrates_id'); //to set the current price
            $table->text('notes')->nullable();
            $table->boolean('is_deactivated')->default(0);
            $table->unsignedBigInteger('machines_id')->default(0);
            $table->unsignedBigInteger('updatedby_id');
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
        Schema::dropIfExists('services');
    }
}
