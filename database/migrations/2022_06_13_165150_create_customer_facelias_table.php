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
        Schema::create('customer_facelias', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->float('amount_available', 50);
            $table->float('amount_interest', 50);
            $table->float('amount_du', 50);
            $table->float('mensuality', 50);
            $table->timestamp('next_expiration')->nullable();
            $table->bigInteger('wallet_payment_id')->unsigned();

            $table->foreignId('customer_pret_id')
                            ->constrained()
                            ->cascadeOnUpdate()
                            ->cascadeOnDelete();

            $table->foreignId('customer_credit_card_id')
                            ->nullable()
                            ->constrained()
                            ->cascadeOnUpdate()
                            ->cascadeOnDelete();

            $table->foreignId('customer_wallet_id')
                            ->constrained()
                            ->cascadeOnUpdate()
                            ->cascadeOnDelete();

            $table->foreign('wallet_payment_id')->references('id')->on('customer_wallets')
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
        Schema::dropIfExists('customer_facelias');
    }
};
