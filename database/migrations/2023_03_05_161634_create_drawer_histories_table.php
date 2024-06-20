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
        Schema::create('drawer_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->float('starting_cash', 12, 2)->default(0);
            $table->float('cash_sales', 12, 2)->default(0);
            $table->float('expected', 12, 2)->default(0);
            $table->float('actual', 12, 2)->default(0);
            $table->float('difference', 12, 2)->default(0);
            $table->float('paid_out', 12, 2)->default(0);
            $table->timestamp('ended_at')->nullable();
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
        Schema::dropIfExists('drawer_histories');
    }
};
