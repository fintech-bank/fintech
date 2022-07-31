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
        Schema::create('customer_documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('reference')->default(Str::upper(Str::random(10)));
            $table->boolean('signable')->default(false)->comment('Le document est-il signable ?');
            $table->boolean('signed_by_client')->default(false)->comment('Le document est signé par le client');
            $table->boolean('signed_by_bank')->default(true)->comment('Le document est signé par la bank');
            $table->string('code_sign')->nullable();
            $table->timestamp('signed_at')->nullable()->comment('Date de signature du document');
            $table->timestamps();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('document_category_id')
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
        Schema::dropIfExists('customer_documents');
    }
};
