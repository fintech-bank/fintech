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
        Schema::create('document_transmisses', function (Blueprint $table) {
            $table->id();
            $table->string('type_document');
            $table->text('commentaire')->nullable();
            $table->boolean('file_transfered')->default(false);
            $table->timestamp('date_transmiss')->nullable();
            $table->string('file_name')->nullable();
            $table->timestamps();

            $table->foreignId('agency_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

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
        Schema::dropIfExists('document_transmisses');
    }
};
