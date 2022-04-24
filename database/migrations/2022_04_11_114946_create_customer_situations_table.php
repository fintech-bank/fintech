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
        Schema::create('customer_situations', function (Blueprint $table) {
            $table->id();
            $table->string("legal_capacity")->nullable();
            $table->string('family_situation')->nullable();
            $table->string("logement")->nullable();
            $table->dateTime('logement_at')->default(now());
            $table->integer('child')->default(0);
            $table->integer('person_charged')->default(0);
            $table->string("pro_category")->nullable();
            $table->string('pro_category_detail')->nullable();
            $table->string("pro_profession")->nullable();

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
        Schema::dropIfExists('customer_situations');
    }
};
