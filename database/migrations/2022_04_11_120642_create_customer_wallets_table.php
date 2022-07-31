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
        Schema::create('customer_wallets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('number_account');
            $table->string('iban');
            $table->string('rib_key');
            $table->enum('type', ['compte', 'pret', 'epargne'])->default('compte');
            $table->enum('status', ['pending', 'active', 'suspended', 'closed'])->default('pending');
            $table->float('balance_actual', 50)->default(0);
            $table->float('balance_coming', 50)->default(0);
            $table->boolean('decouvert')->default(false);
            $table->float('balance_decouvert', 50)->default(0);
            $table->boolean('alert_debit')->default(false);
            $table->boolean('alert_fee')->default(false);
            $table->timestamp('alert_date')->nullable();

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
        Schema::dropIfExists('customer_wallets');
    }
};
