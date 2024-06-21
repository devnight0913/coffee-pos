<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('recipe_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('item_id')->constrained()->onDelete('cascade');
            $table->float('quantity');
            $table->integer('tax_rate');
            $table->string('vat_type');
            $table->float('price', 12, 2);
            $table->float('cost', 12, 2);
            $table->float('total', 12, 2);
            $table->float('total_cost', 12, 2);
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
        Schema::dropIfExists('order_details');
    }
}
