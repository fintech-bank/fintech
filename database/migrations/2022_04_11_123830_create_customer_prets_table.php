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
        Schema::create('customer_prets', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('reference');
            $table->float('amount_loan', 50)->comment('Montant du crédit demander');
            $table->float('amount_interest', 50)->comment('Montant des interet du par le client');
            $table->float('amount_du', 50)->comment('Total des sommes du par le client (Credit + Interet - mensualités payé)');
            $table->float('mensuality', 50)->comment('Mensualité du par le client par mois');
            $table->integer('prlv_day')->default(5)->comment('Jours du prélèvement de la mensualité');
            $table->integer('duration')->comment('Durée total du contrat en année');
            $table->enum('status', ['open', 'study', 'accepted', 'refused', 'progress', 'terminated', 'error'])->default('open');
            $table->boolean('signed_customer')->default(false);
            $table->boolean('signed_bank')->default(false);
            $table->boolean('alert')->default(false);
            $table->enum('assurance_type', ['D', 'DIM', 'DIMC'])->default('DIM');
            $table->bigInteger('customer_wallet_id')->unsigned();
            $table->bigInteger('wallet_payment_id')->unsigned();
            $table->timestamps();
            $table->timestamp('first_payment_at')->nullable();

            $table->foreign('customer_wallet_id')->references('id')->on('customer_wallets')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('wallet_payment_id')->references('id')->on('customer_wallets')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('loan_plan_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::table('customer_credit_cards', function (Blueprint $table) {
            $table->foreignId('customer_pret_id')
                            ->nullable()
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
        Schema::dropIfExists('customer_prets');
    }
};
