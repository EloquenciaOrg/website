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
        Schema::create('lessons_chapters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Chapter name');
            $table->text('description')->nullable()->comment('Chapter description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons_chapters');
    }
};
