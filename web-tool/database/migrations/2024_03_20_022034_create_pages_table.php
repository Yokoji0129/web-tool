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
        Schema::create('pages', function (Blueprint $table) {
            $table->bigInteger('diary_id')->nullalbe(false);
            $table->id('page_id');
            $table->string('page_title',255)->nullable();
            $table->string('page_title_color',255)->nullable();
            $table->string('page_txt1',255)->nullable();
            $table->string('page_txt2',255)->nullable();
            $table->string('page_marker_color', 255)->nullable();
            $table->string('page_txt_color',255)->nullable();
            $table->string('page_file1',255)->nullable();
            $table->string('page_file_txt1',255)->nullable();
            $table->string('page_file2',255)->nullable();
            $table->string('page_file_txt2',255)->nullable();
            $table->string('page_file3',255)->nullable();
            $table->string('page_file_txt3',255)->nullable();
            $table->string('page_file4',255)->nullable();
            $table->string('page_file_txt4',255)->nullable();
            $table->string('page_file5',255)->nullable();
            $table->string('page_file_txt5',255)->nullable();
            $table->string('page_file6',255)->nullable();
            $table->string('page_file_txt6',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
