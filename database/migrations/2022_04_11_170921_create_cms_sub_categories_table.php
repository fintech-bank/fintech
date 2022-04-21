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
        Schema::create('cms_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->boolean('parent');

            $table->unsignedBigInteger('parent_id')->nullable();

            $table->foreign('parent_id')->references('id')->on('cms_sub_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('cms_category_id')
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
        Schema::dropIfExists('cms_sub_categories');
    }
};
