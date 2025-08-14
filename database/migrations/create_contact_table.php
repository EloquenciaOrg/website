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
        Schema::create('contact', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40)->comment('The name of the person');
            $table->string('email')->comment('The email address of the person');
            $table->text('message')->comment('The message sent');
            $table->dateTime('datetime')->default(now())->comment('The date and time when the message was sent');
            $table->string('ip', 45)->comment('The IP address of the person sending the message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact');
    }
};
