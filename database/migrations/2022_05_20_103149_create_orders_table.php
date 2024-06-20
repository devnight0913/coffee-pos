<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('number');
            $table->float('delivery_charge', 12, 2);
            $table->integer('tax_rate');
            $table->integer('paid');
            $table->string('vat_type');
            $table->float('subtotal', 12, 2);
            $table->float('discount', 12, 2);
            $table->float('total', 12, 2);
            $table->float('tender_amount', 12, 2);
            $table->float('change', 12, 2);
            $table->float('exchange_rate', 12, 2)->nullable();
            $table->string('exchange_rate_currency', 12, 2)->nullable();
            $table->longText('remarks')->nullable();

            $table->string('type')->nullable();
            $table->boolean('show_exchange_rate')->default(false);
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
        Schema::dropIfExists('orders');
    }
}
