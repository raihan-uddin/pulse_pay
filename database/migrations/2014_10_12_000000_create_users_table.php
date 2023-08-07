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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('username')->unique();
            $table->string('phonecode');
            $table->string('phone_number')->unique();
            $table->enum('account_type', ['merchant', 'user', 'admin'])->default('user');
            $table->string('currency_code')->nullable();
            $table->string('country_code')->comment('iso2')->nullable();
            $table->decimal('balance', 20, 8)->default(0);
            $table->decimal('point', 20, 8)->default(0);
            $table->decimal('commission', 20, 8)->default(0);
            $table->enum('status', config('status.account_status'))->default('pending_verification');
            $table->string('password', 300);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('referral_code')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
