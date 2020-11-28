<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTableName(), function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('image_id');
            $table->foreign('image_id')
                ->references('id')
                ->on(config('table_names.image'))
                ->onDelete('cascade');

            $table->string('tag');
            $table->string('name');
            $table->integer('width');
            $table->integer('height');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName());
    }

    private function getTableName()
    {
        return config('table_names.image_variation');
    }
}
