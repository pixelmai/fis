<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('companies', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('email')->nullable(); 
      $table->string('number')->nullable();
      $table->text('address')->nullable();
      $table->text('url')->nullable();
      $table->tinyInteger('partner_id')->default(1);//partner in settings
      $table->tinyInteger('client_id'); //contact_person
      $table->text('description')->nullable();
      $table->boolean('is_partner')->default(0);
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
    Schema::dropIfExists('companies');
  }
}
