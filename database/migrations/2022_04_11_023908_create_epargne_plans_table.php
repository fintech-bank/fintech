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
        Schema::create('epargne_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('profit_percent');
            $table->integer('lock_days');
            $table->integer('profit_days')->default(30);
            $table->float('init')->default(0);
            $table->float('limit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('epargne_plans');
    }
};
