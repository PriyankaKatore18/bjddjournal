<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('special_issues', function (Blueprint $table) {
            $table->string('cover_pdf_path')->nullable()->after('cover_image');
            $table->string('index_pdf_path')->nullable()->after('cover_pdf_path');
            $table->string('full_issue_pdf_path')->nullable()->after('index_pdf_path');
        });
    }

    public function down(): void
    {
        Schema::table('special_issues', function (Blueprint $table) {
            $table->dropColumn(['cover_pdf_path', 'index_pdf_path', 'full_issue_pdf_path']);
        });
    }
};
