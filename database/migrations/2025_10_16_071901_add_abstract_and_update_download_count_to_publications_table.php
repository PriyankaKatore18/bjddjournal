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
        Schema::table('publications', function (Blueprint $table) {
            // 1. Add the new 'abstract' field (Existing logic)
            $table->text('abstract')->nullable()->after('crossref_doi');

            // NEW: Add the 'certificate_path' field to store the image file location
            $table->string('certificate_path')->nullable()->after('abstract');

            // 2. Ensure download_count is an integer and defaults to 0 (Existing logic)
            // We use 'change()' to modify an existing column's properties.
            // Note: If you have data in this column already, you might need to
            // install the 'doctrine/dbal' package: composer require doctrine/dbal
            $table->unsignedInteger('download_count')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            // Drop the abstract column (Existing logic)
            $table->dropColumn('abstract');

            // NEW: Drop the certificate_path column
            $table->dropColumn('certificate_path');

            // Reverse the change for download_count (revert to previous state, e.g., nullable string)
            // You should replace 'string' with whatever the original type was if it wasn't integer/unsignedInteger.
            $table->string('download_count')->nullable()->change();
        });
    }
};
