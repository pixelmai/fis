<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicesrates', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('services_id');
            $table->decimal('def_price',10, 6);
            $table->decimal('up_price',10, 6);
            $table->unsignedBigInteger('updatedby_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servicesrates');
    }
}
