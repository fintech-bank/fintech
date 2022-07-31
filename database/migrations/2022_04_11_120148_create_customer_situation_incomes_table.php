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
        Schema::create('customer_situation_incomes', function (Blueprint $table) {
            $table->id();
            $table->float('pro_incoming')->default(0)->comment('Revenue Salarial, Aide état RSA, etc...');
            $table->float('patrimoine')->default(0)->comment('Revenue Mensuel du patrimoine');

            $table->foreignId('customer_id')
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
        Schema::dropIfExists('customer_situation_incomes');
    }
};
