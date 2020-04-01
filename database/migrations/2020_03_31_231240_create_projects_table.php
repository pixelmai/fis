<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable(); 
            $table->text('url')->nullable();
            $table->tinyInteger('status')->default(1); 
            $table->unsignedBigInteger('client_id'); 
            $table->boolean('is_categorized')->default(0);
            $table->boolean('is_deactivated')->default(0);
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
        Schema::dropIfExists('projects');
    }
}
