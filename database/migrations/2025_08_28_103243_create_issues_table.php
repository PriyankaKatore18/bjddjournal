<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('volume')->nullable();
            $table->string('number')->nullable();
            $table->date('publish_date')->nullable();
            // Add the new fields here
            $table->string('registration_id')->nullable();
            $table->string('published_paper_id')->nullable();
            $table->string('year')->nullable();
            $table->string('approved_eissn')->nullable();
            $table->string('country')->nullable();
            $table->string('crossref_doi_member_id')->nullable();
            $table->string('page_no')->nullable();
            $table->integer('downloads_count')->default(0);
            $table->string('published_paper_url')->nullable();
            $table->string('published_paper_pdf')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};