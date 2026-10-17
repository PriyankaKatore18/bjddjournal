<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('special_issue_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('special_issue_id')->constrained()->cascadeOnDelete();
            $table->string('paper_id')->unique();
            $table->string('article_title');
            $table->string('language')->default('English');
            $table->string('main_author');
            $table->text('co_authors')->nullable();
            $table->string('affiliation')->nullable();
            $table->string('country')->nullable();
            $table->string('pages')->nullable();
            $table->date('published_date')->nullable();
            $table->string('doi')->nullable();
            $table->string('eissn')->nullable();
            $table->string('final_pdf_path')->nullable();
            $table->string('certificate_path')->nullable();
            $table->longText('abstract')->nullable();
            $table->text('keywords')->nullable();
            $table->string('status')->default('draft');
            $table->unsignedInteger('download_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('special_issue_articles');
    }
};
