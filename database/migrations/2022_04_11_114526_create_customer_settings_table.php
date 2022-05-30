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
        Schema::create('customer_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('notif_sms')->default(false);
            $table->boolean('notif_app')->default(false);
            $table->boolean('notif_mail')->default(false);
            $table->integer('nb_physical_card')->default(1);
            $table->integer('nb_virtual_card')->default(1);
            $table->boolean('check')->default(false);

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
        Schema::dropIfExists('customer_settings');
    }
};
