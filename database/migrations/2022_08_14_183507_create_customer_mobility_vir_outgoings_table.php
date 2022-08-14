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
        Schema::create('customer_mobility_vir_outgoings', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->float('amount', 50);
            $table->string('reference');
            $table->string('reason');
            $table->timestamp('transfer_date')->nullable();
            $table->boolean('valid')->default(0);

            $table->foreignId('customer_mobility_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_mobility_vir_outgoings');
    }
};
