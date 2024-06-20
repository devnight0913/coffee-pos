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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number');
            $table->foreignUuid('customer_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignUuid('employee_id')->constrained()->onDelete('cascade')->nullable();
            $table->float('amount', 12, 2)->default(0);
            $table->longText('comments')->nullable();
            $table->string('mode')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('payments');
    }
};
