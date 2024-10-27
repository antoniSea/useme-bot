<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table("useme_jobs", function (Blueprint $table) {
           $table->longText('proposal_generated')->nullable();
           $table->longText('additional_website_data')->nullable();
           $table->integer('price')->nullable();
           $table->integer('tech_stack')->nullable();
           $table->json('additional_indo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
