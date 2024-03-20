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
            $table->id();
            $table->biginteger('page_id')->nullable(false);
            $table->string('page_title',255)->nullable(false);
            $table->string('page_txt',255)->nullable(false);
            $table->string('page_file1',255)->nullable();
            $table->string('page_file2',255)->nullable();
            $table->string('page_file3',255)->nullable();
            $table->string('page_file4',255)->nullable();
            $table->string('page_file5',255)->nullable();
            $table->string('page_file6',255)->nullable();
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
