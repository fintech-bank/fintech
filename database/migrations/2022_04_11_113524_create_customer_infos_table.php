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
        Schema::create('customer_infos', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['part', 'pro'])->default('part');
            $table->enum('civility', ['M', 'Mme', 'Mlle'])->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->dateTime('datebirth')->nullable();
            $table->string('citybirth')->nullable();
            $table->string('countrybirth')->nullable();
            $table->string('company')->nullable();
            $table->string('siret')->nullable();
            $table->string('address');
            $table->string('addressbis')->nullable();
            $table->string('postal');
            $table->string('city');
            $table->string('country');
            $table->string('phone')->nullable();
            $table->string('mobile');
            $table->string('country_code')->nullable();
            $table->string('authy_id')->nullable();
            $table->boolean('isVerified')->default(false);

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
        Schema::dropIfExists('customer_infos');
    }
};
