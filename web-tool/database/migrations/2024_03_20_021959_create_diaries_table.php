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
        Schema::create('diaries', function (Blueprint $table) {
            $table->string('account_id',255)->nullable(false);
            $table->id('diary_id');
            $table->string('diary_name',255)->nullable(false);
            $table->string('diary_top_file',255)->nullable(false);
            $table->string('diary_color',255)->nullable(false);
            $table->string('diary_text_color', 255)->nullable(false);
            $table->string('diary_font', 255)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diaries');
    }
};
