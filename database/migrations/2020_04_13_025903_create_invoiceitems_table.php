<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoiceitems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoices_id')->default(0);
            $table->decimal('quantity', 7, 2);
            $table->unsignedBigInteger('services_id')->default(1);
            $table->unsignedBigInteger('machines_id')->default(0);
            $table->unsignedBigInteger('servicesrates_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoiceitems');
    }
}
