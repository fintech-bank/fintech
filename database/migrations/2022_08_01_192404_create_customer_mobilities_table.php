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
        Schema::create('customer_mobilities', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['bank_start', 'bank_return', 'creditor_start', 'creditor_end']);
            $table->string('old_iban');
            $table->string('old_bic')->nullable();
            $table->string('mandate');
            $table->timestamp('start');
            $table->timestamp('end_prov');
            $table->timestamp('env_real')->nullable();
            $table->timestamp('end_prlv')->nullable();
            $table->integer('close_account')->default(0);
            $table->longText('comment')->nullable();
            $table->string('code')->nullable();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('bank_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

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
        Schema::dropIfExists('customer_mobilities');
    }
};
