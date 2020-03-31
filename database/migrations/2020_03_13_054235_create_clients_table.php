<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->enum('gender', ['m', 'f']);
            $table->date('date_of_birth')->nullable();
            $table->string('email')->nullable(); 
            $table->string('number')->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('company_id')->default(1);
            $table->string('position')->nullable();
            $table->tinyInteger('regtype_id');
            $table->tinyInteger('sector_id');
            $table->text('url')->nullable();
            $table->text('skillset')->nullable();
            $table->text('hobbies')->nullable();
            $table->boolean('is_pwd')->default(0);
            $table->boolean('is_freelancer')->default(0);
            $table->boolean('is_food')->default(0);
            $table->boolean('is_imported')->default(0);
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
        Schema::dropIfExists('clients');
    }
}
