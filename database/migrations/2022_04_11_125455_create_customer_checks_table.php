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
        Schema::create('customer_checks', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->integer('tranche_start');
            $table->integer('tranche_end');
            $table->enum('status', ['checkout', 'manufacture', 'ship', 'outstanding', 'finish', 'destroy'])->default('checkout');
            $table->timestamps();

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
        Schema::dropIfExists('customer_checks');
    }
};
