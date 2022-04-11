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
        Schema::create('customer_epargnes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('reference');
            $table->float('initial_payment');
            $table->float('monthly_payment');
            $table->integer('monthly_days')->default(15);
            $table->bigInteger('wallet_id')->unsigned();
            $table->foreign('wallet_id')->references('id')->on('customer_wallets')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->bigInteger('wallet_payment_id')->unsigned();
            $table->foreign('wallet_payment_id')->references('id')->on('customer_wallets')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('epargne_plan_id')
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
        Schema::dropIfExists('customer_epargnes');
    }
};
