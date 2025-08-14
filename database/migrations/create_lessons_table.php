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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->comment('Title of the lesson');
            $table->string('summary', 1024)->comment('Brief summary of the lesson');
            $table->text('content')->comment('Detailed content of the lesson');
            $table->integer('chapter')->nullable()->comment('Chapter number this lesson belongs to');
            //$table->foreign('chapter')->references('id')->on('lessons_chapters')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
