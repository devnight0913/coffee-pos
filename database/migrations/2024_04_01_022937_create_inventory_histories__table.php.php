<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('inventory_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->float('invoices', 12, 2)->default(0);
            $table->float('customers', 12, 2)->default(0);
            $table->float('cash_sales', 12, 2)->default(0);
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('inventory_histories');
    }
};
