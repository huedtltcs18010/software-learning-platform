<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosFeaturedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->text('json_data')->nullable();
            $table->unsignedInteger('status')->index();
            $table->timestamps();
        });
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->text('json_data')->nullable();
            $table->unsignedInteger('status')->index();
            $table->timestamps();
        });
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('thumbnail');
            $table->text('description');
            $table->string('filename');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreignId('category_id')
                ->constrained()
                ->onDelete('cascade');
            $table->unsignedBigInteger('series_id');
            $table->foreign('series_id')
                ->references('id')
                ->on('series')
                ->onDelete('cascade');
            $table->text('json_data')->nullable();
            $table->unsignedBigInteger('duration')->default(0)->index();
            $table->unsignedBigInteger('total_view')->default(0)->index();
            $table->unsignedBigInteger('total_comment')->default(0)->index();
            $table->unsignedInteger('rating_star')->index();
            $table->unsignedInteger('status')->index();
            $table->timestamps();
        });
        Schema::create('reported_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')
                ->constrained()
                ->onDelete('cascade');
            $table->unsignedBigInteger('reporter_id');
            $table->foreign('reporter_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedInteger('status')->index();
            $table->timestamps();
        });
        Schema::create('user_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('video_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('message');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedInteger('status');
            $table->timestamps();
        });
        Schema::create('banned_words', function (Blueprint $table) {
            $table->id();
            $table->string('word')->index();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('reported_videos');
        Schema::dropIfExists('user_videos');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('series');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('banned_words');
    }
}
