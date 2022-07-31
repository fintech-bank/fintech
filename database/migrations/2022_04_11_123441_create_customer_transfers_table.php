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
        Schema::create('customer_transfers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->float('amount');
            $table->string('reference');
            $table->string('reason');
            $table->enum('type', ['immediat', 'differed', 'permanent']);
            $table->timestamp('transfer_date')->nullable();
            $table->timestamp('recurring_start')->nullable();
            $table->timestamp('recurring_end')->nullable();
            $table->enum('status', ['paid', 'pending', 'in_transit', 'canceled', 'failed'])->default('pending');
            $table->integer('transaction_id')->nullable();

            $table->foreignId('customer_wallet_id')
                            ->constrained()
                            ->cascadeOnUpdate()
                            ->cascadeOnDelete();

            $table->foreignId('customer_beneficiaire_id')
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
        Schema::dropIfExists('customer_transfers');
    }
};
