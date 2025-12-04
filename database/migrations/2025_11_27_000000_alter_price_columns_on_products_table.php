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
        Schema::table('products', function (Blueprint $table) {
            // Allow larger monetary values and tax rates
            $table->decimal('regular_price', 12, 2)->change();
            $table->decimal('discounted_price', 12, 2)->nullable()->change();
            $table->decimal('tax_rate', 10, 2)->default(0.00)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert to the original column definitions
            $table->decimal('regular_price', 8, 2)->change();
            $table->decimal('discounted_price', 8, 2)->nullable()->change();
            $table->decimal('tax_rate', 5, 2)->default(0.00)->change();
        });
    }
};


