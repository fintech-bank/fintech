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
        Schema::create('customer_check_deposit_lists', function (Blueprint $table) {
            $table->id();
            $table->string('number', 7);
            $table->float('amount');
            $table->string('name_deposit');
            $table->string('bank_deposit');
            $table->timestamp('date_deposit');
            $table->boolean('verified')->default(false);

            $table->foreignId('customer_check_deposit_id')
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
        Schema::dropIfExists('customer_check_deposit_lists');
    }
};
