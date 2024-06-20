<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drawers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->float('amount', 12, 2)->default(0);
            $table->foreignUuid('order_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignUuid('payment_id')->nullable()->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('drawers');
    }
};
