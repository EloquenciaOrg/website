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
        Schema::create('blog', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Title of the article');
            $table->string('summary')->nullable()->comment('Summary of the article');
            $table->longText('content')->comment('Content of the article');
            $table->tinyText('pic')->nullable()->comment('Picture associated with the article');
            $table->date('publishdate')->default(now())->comment('Date of publication');
            $table->tinyInteger('featured')->default(0)->comment('Featured status of the article');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog');
    }
};
