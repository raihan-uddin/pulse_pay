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
        Schema::create('transaction_fee', function (Blueprint $table) {
            $table->id();
            $table->enum('transaction_type', config('types.transaction_type'));
            $table->enum('fee_type', config('types.fee_type'));
            $table->string('currency_code'); // Currency code in which the fee is applied
            $table->decimal('amount', 20, 8)->default(0)->comment("The fixed fee amount (if applicable). If the fee_type is 'Percentage' or 'Mixed' this column will be 0.");
            $table->decimal('percentage', 20, 8)->default(0)->comment("The fee percentage (if applicable). If the fee_type is 'Fixed' this column will be 0.");
            $table->decimal('min_amount', 20, 8)->default(0)->comment('Minimum transaction amount to apply the fee (optional)');
            $table->decimal('max_amount', 20, 8)->default(0)->comment('Maximum transaction amount to apply the fee (optional)');
            $table->decimal('description', 20, 8)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_fee');
    }
};
