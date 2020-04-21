<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clients_id')->default(1);
            $table->unsignedBigInteger('companies_id')->default(1);
            $table->unsignedBigInteger('projects_id')->default(0);
            $table->unsignedBigInteger('status')->default(1); //draft, etc
            $table->boolean('is_up')->default(0);
            $table->unsignedBigInteger('jobs')->default(0);
            $table->decimal('discount', 5, 2);
            $table->unsignedBigInteger('discount_type')->default(0);
            $table->decimal('subtotal',15, 4);
            $table->decimal('total',15, 4);
            $table->date('due_date')->nullable(); 
            $table->unsignedBigInteger('updatedby_id');
            $table->boolean('is_saved')->default(0);
            $table->string('token')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
