<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficialbills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('officialbills', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->unsigned();
            $table->string('for_name'); 
            $table->string('for_company')->nullable();
            $table->string('for_position')->nullable();
            $table->text('for_address')->nullable();
            $table->text('letter')->nullable();
            $table->date('billing_date'); 
            $table->string('by_name'); 
            $table->string('by_position');
            $table->tinyInteger('status')->default(1); 
            $table->unsignedBigInteger('createdby_id');
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
        Schema::dropIfExists('officialbills');
    }
}
