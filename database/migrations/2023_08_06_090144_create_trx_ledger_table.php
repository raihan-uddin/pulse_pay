<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trx_ledger', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('trx_no');
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('transaction_type', config('types.transaction_type'));
            $table->decimal('cr_amount', 20, 8)->default(0);
            $table->decimal('dr_amount', 20, 8)->default(0);
            $table->string('source_currency_code', 3);
            $table->string('target_currency_code', 3);
            $table->decimal('exchange_rate', 20, 8);
            $table->decimal('transaction_fee', 20, 8)->default(0);
            $table->decimal('commission', 20, 8)->default(0);
            $table->decimal('point', 20, 8)->default(0);
            $table->decimal('vat', 20, 8)->default(0);
            $table->dateTime('transaction_date')->default(DB::raw('NOW()'));
            $table->string('description')->nullable();
            $table->enum('status', config('status.transaction_status'));
            $table->string('reference_id')->nullable();
            $table->enum('transaction_method', config('types.transaction_method'));
            $table->string('mfs_account_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trx_ledger');
    }
};
