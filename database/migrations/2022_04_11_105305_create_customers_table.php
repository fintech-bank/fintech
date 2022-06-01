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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->enum("status_open_account", ["open", "completed", "accepted", "declined", "terminated", "suspended", "closed"])->default("open");
            $table->integer("cotation")->default(5)->comment("Cotation bancaire du client");
            $table->string('auth_code');
            $table->boolean('ficp')->default(false);
            $table->boolean('fcc')->default(false);
            $table->unsignedBigInteger('agent_id')->unsigned()->nullable();

            $table->foreignId('user_id')
                            ->constrained()
                            ->cascadeOnUpdate()
                            ->cascadeOnDelete();

            $table->foreignId('package_id')
                            ->constrained()
                            ->cascadeOnUpdate()
                            ->cascadeOnDelete();

            $table->foreignId('agency_id')
                            ->constrained()
                            ->cascadeOnUpdate()
                            ->cascadeOnDelete();

            $table->foreign('agent_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
