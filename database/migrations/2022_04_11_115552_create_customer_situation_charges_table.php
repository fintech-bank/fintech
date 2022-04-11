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
        Schema::create('customer_situation_charges', function (Blueprint $table) {
            $table->id();
            $table->float('rent')->default(0)->comment("Loyer, Pret Immobilier, etc...");
            $table->integer('nb_credit')->default(0)->comment("Nombre de crédit actuel");
            $table->float('credit')->default(0)->comment("Valeur total des mensualité de crédit");
            $table->float('divers')->default(0)->comment("Autres charges (pension, etc...)");

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
        Schema::dropIfExists('customer_situation_charges');
    }
};
