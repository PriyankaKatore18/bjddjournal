<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('issues') && !Schema::hasColumn('issues', 'cover_image')) {
            Schema::table('issues', function (Blueprint $table) {
                $table->string('cover_image')->nullable()->after('published_paper_pdf');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('issues') && Schema::hasColumn('issues', 'cover_image')) {
            Schema::table('issues', function (Blueprint $table) {
                $table->dropColumn('cover_image');
            });
        }
    }
};
