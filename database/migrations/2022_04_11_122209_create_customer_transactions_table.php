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
        Schema::create('customer_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->enum('type', ['depot', 'retrait', 'payment', 'virement', 'sepa', 'frais', 'souscription', 'autre', 'facelia']);
            $table->string('designation');
            $table->string('description')->nullable();
            $table->float('amount');
            $table->boolean('confirmed');
            $table->boolean('differed')->default(false);
            $table->timestamp('confirmed_at')->nullable();
            $table->time('differed_at')->nullable();
            $table->timestamps();

            $table->foreignId('customer_wallet_id')
                            ->constrained()
                            ->cascadeOnUpdate()
                            ->cascadeOnDelete();

            $table->foreignId('customer_credit_card_id')
                ->nullable()
                ->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_transactions');
    }
};
