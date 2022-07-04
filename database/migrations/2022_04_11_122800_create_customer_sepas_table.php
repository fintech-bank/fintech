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
        Schema::create('customer_sepas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('creditor');
            $table->string('number_mandate');
            $table->float('amount');
            $table->enum('status', ['waiting', 'processed', 'rejected', 'return', 'refunded']);
            $table->timestamps();
            $table->integer('transaction_id')->nullable();

            $table->foreignId('customer_wallet_id')
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
        Schema::dropIfExists('customer_sepas');
    }
};
