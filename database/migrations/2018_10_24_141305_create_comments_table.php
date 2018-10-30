<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('thread_id');
            $table->string('title')->nullable();
            $table->text('content');
            $table->unsignedInteger('creator_user_id')->nullable();
            $table->string('creator_name')->nullable();
            $table->timestamps();
            $table->foreign('thread_id')->references('id')->on('threads')->onDelete('cascade');
            $table->foreign('creator_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
