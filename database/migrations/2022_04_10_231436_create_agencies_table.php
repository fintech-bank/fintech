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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bic');
            $table->string('code_banque');
            $table->string('code_agence');
            $table->string('address');
            $table->string('postal');
            $table->string('city');
            $table->string('country', 2);
            $table->boolean('online')->default(false);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('agency_id')->nullable()
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
        Schema::dropIfExists('agencies');
    }
};
