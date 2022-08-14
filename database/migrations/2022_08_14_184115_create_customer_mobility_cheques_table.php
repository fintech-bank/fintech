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
        Schema::create('customer_mobility_cheques', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->float('amount', 50);
            $table->timestamp('date_enc');
            $table->string('creditor');
            $table->string('file_url');
            $table->boolean('valid')->default(0);

            $table->foreignId('customer_mobility_id')
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
        Schema::dropIfExists('customer_mobility_cheques');
    }
};
