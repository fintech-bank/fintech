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
        Schema::create('customer_credit_cards', function (Blueprint $table) {
            $table->id();
            $table->string('currency', 3)->default('EUR');
            $table->string('exp_month', 2);
            $table->string('exp_year', 4)->default(now()->addYears(4)->year);
            $table->string('number');
            $table->enum('status', ['active', 'inactive', 'canceled'])->default('inactive');
            $table->enum('type', ['physique', 'virtuel'])->default('physique');
            $table->enum('support', ['classic', 'premium', 'infinite'])->default('classic');
            $table->enum('debit', ['immediate', 'differed'])->default('immediate');
            $table->string('cvc', 4);
            $table->boolean('payment_internet')->default(true);
            $table->boolean('payment_abroad')->default(false);
            $table->boolean('payment_contact')->default(true);
            $table->string('code');
            $table->float('limit_retrait');
            $table->float('limit_payment');
            $table->float('differed_limit')->default(0);
            $table->boolean('facelia')->default(false);
            $table->boolean('visa_spec')->default(false);
            $table->boolean('warranty')->default(false);

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
        Schema::dropIfExists('customer_credit_cards');
    }
};
