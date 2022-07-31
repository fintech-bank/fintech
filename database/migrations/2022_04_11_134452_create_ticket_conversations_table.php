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
        Schema::create('ticket_conversations', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->timestamps();

            $table->bigInteger('agent_id')->unsigned();
            $table->foreign('agent_id')->references('id')->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->bigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('ticket_id')
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
        Schema::dropIfExists('ticket_conversations');
    }
};
