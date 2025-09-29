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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Full name');
            $table->string('firstname')->comment('First name');
            $table->string('email')->unique()->comment('Email address');
            $table->string('moodle_login')->unique();
            $table->string('password')->nullable()->comment('Password in bcrypt format');
            $table->tinyInteger('newsletter')->default(0)->comment('0 if not subscribed, 1 if subscribed');
            $table->datetime('registrationDate')->default(now())->comment('Membership registration date');
            $table->datetime('expirationDate')->default(now() ->addYear())->comment('Membership expiration date');
            $table->datetime('lmsAccessExpiration')->nullable()->comment('LMS access expiration date');
            $table->tinyInteger('isAdmin')->default(0)->comment('0 if regular member, 1 if admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
