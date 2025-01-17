<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author', function (Blueprint $table) {
            $table->id();
            $table->string('title', 2555);
            $table->string('slug', 100);
            $table->string('designation', 255);
            $table->string('dob', 100);
            $table->string('country', 100);
            $table->string('email', 100)->unique();
            $table->string('phone', 2555);
            $table->text('description')->nullable();
            $table->string('author_feature', 100);
            $table->string('facebook_id', 100)->unique();
            $table->string('twitter_id', 100)->unique();  
            $table->string('youtube_id', 100)->unique();
            $table->string('pinterest_id', 100)->unique();
            $table->string('author_img', 1055);
            $table->string('status', 10);
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
        Schema::dropIfExists('author');
    }
}
