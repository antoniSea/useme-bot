<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('useme_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('avatar_url');
            $table->string('offers_count');
            $table->string('time_remaining');
            $table->string('title');
            $table->string('job_url')->unique();
            $table->text('preview_description');
            $table->text('full_description');
            $table->string('category');
            $table->string('category_url');
            $table->string('budget');
            $table->integer('page');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('useme_jobs');
    }
};