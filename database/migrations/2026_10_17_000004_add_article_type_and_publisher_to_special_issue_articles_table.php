<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('special_issue_articles', function (Blueprint $table) {
            $table->string('article_type')->default('Research Article')->after('article_title');
            $table->string('publisher')->default('BJDD Journal')->after('eissn');
        });
    }

    public function down(): void
    {
        Schema::table('special_issue_articles', function (Blueprint $table) {
            $table->dropColumn(['article_type', 'publisher']);
        });
    }
};
