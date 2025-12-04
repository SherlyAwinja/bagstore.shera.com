<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['subcategory_id']);
        });

        // Only run this ALTER TABLE on MySQL/MariaDB where the backtick syntax is valid.
        if (in_array($driver, ['mysql', 'mariadb'])) {
            DB::statement('ALTER TABLE `products` MODIFY `subcategory_id` BIGINT UNSIGNED NULL');
        } else {
            // For other drivers (e.g. SQLite, PostgreSQL), this migration does not
            // currently implement a portable column alteration. Failing loudly here
            // avoids a situation where some environments have a nullable column and
            // others do not, which would be very hard to debug.
            throw new \RuntimeException(
                'Migration "make_subcategory_id_nullable_in_products_table" is only implemented for MySQL/MariaDB. ' .
                'Either adjust the migration for your database driver or avoid relying on subcategory_id being nullable.'
            );
        }
        // For MySQL/MariaDB, the column is now nullable; we can safely recreate the FK.
        
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['subcategory_id']);
        });

        // Only run the MySQL/MariaDB-specific ALTER TABLE on those drivers.
        if (in_array($driver, ['mysql', 'mariadb'])) {
            // Ensure there are no NULL values before making the column NOT NULL again,
            // otherwise the ALTER TABLE statement would fail.
            $hasNulls = DB::table('products')
                ->whereNull('subcategory_id')
                ->exists();

            if ($hasNulls) {
                // Try to assign NULLs to an existing subcategory if one exists.
                $defaultSubcategoryId = DB::table('subcategories')
                    ->orderBy('id')
                    ->value('id');

                if ($defaultSubcategoryId !== null) {
                    DB::table('products')
                        ->whereNull('subcategory_id')
                        ->update(['subcategory_id' => $defaultSubcategoryId]);

                    $hasNulls = false;
                }
            }

            // Only make the column NOT NULL again if we've successfully
            // eliminated all NULL values. If NULLs remain and cannot be assigned
            // to a default subcategory, fail loudly rather than silently leaving
            // the column in an inconsistent nullable state.
            if ($hasNulls) {
                throw new \RuntimeException(
                    'Cannot rollback migration: products table contains NULL subcategory_id values ' .
                    'and no default subcategory exists to assign them to. Please manually assign ' .
                    'subcategory_id values to all products before rolling back this migration.'
                );
            }

            DB::statement('ALTER TABLE `products` MODIFY `subcategory_id` BIGINT UNSIGNED NOT NULL');
        } else {
            // See note in up(): this migration only targets MySQL/MariaDB. Reverting
            // on other drivers would require a separate, driver-specific strategy.
            throw new \RuntimeException(
                'Rollback of "make_subcategory_id_nullable_in_products_table" is only implemented for MySQL/MariaDB.'
            );
        }
        
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
        });
    }
};
