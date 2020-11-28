<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
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

            $table->string('title');
            $table->text('body');
            $table->boolean('status');

            $table->json('content_list')->nullable();
            $table->text('processed_content')->nullable();

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
        return config('table_names.post');
    }
}
